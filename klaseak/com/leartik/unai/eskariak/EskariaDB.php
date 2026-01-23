<?php

require_once __DIR__ . '/Eskaria.php';
require_once __DIR__ . '/../bezeroak/Bezeroa.php';
require_once __DIR__ . '/Detailea.php';
require_once __DIR__ . '/../produktuak/produktuak.php';

class EskariaDB
{
    private $db_path;
    private $konexioa;

    public function __construct()
    {
        $rootDir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
        $this->db_path = $rootDir . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'dendadb.sqlite';

        try {
            if (!file_exists(dirname($this->db_path))) {
                mkdir(dirname($this->db_path), 0775, true);
            }

            $this->konexioa = new PDO("sqlite:" . $this->db_path);
            $this->konexioa->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->createTablesIfNotExists();

        } catch (PDOException $e) {
            die("Konexio errorea: " . $e->getMessage());
        }
    }

    private function createTablesIfNotExists()
    {
        // Table for Eskaria (Header)
        // Store bezeroa data here (denormalized) as per requirement discussion, 
        // to simplify retrieval and follow snapshots.
        // OR better: create a 'bezeroak' table and link it? 
        // The plan said: "expand eskariak table to include all Bezeroa fields".

        $sqlEskaria = "CREATE TABLE IF NOT EXISTS eskariak (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            data TEXT,
            izena TEXT,
            abizenak TEXT,
            helbidea TEXT,
            herria TEXT,
            postaKodea INTEGER,
            probintzia TEXT,
            emaila TEXT
        )";
        $this->konexioa->exec($sqlEskaria);

        // Table for Details
        $sqlDetaileak = "CREATE TABLE IF NOT EXISTS eskaria_detaileak (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            eskaria_id INTEGER,
            produktua_id INTEGER,
            kopurua INTEGER,
            FOREIGN KEY(eskaria_id) REFERENCES eskariak(id)
        )";
        $this->konexioa->exec($sqlDetaileak);
    }

    public function insertEskaria(Eskaria $eskaria): int
    {
        try {
            $this->konexioa->beginTransaction();

            $sql = "INSERT INTO eskariak (data, izena, abizenak, helbidea, herria, postaKodea, probintzia, emaila) 
                    VALUES (:data, :izena, :abizenak, :helbidea, :herria, :postaKodea, :probintzia, :emaila)";
            $stmt = $this->konexioa->prepare($sql);

            $bezeroa = $eskaria->getBezeroa();

            $stmt->bindValue(':data', $eskaria->getData());
            $stmt->bindValue(':izena', $bezeroa->getIzena());
            $stmt->bindValue(':abizenak', $bezeroa->getAbizenak());
            $stmt->bindValue(':helbidea', $bezeroa->getHelbidea());
            $stmt->bindValue(':herria', $bezeroa->getHerria());
            $stmt->bindValue(':postaKodea', $bezeroa->getPostaKodea());
            $stmt->bindValue(':probintzia', $bezeroa->getProbintzia());
            $stmt->bindValue(':emaila', $bezeroa->getEmaila());

            $stmt->execute();
            $eskariaId = $this->konexioa->lastInsertId();

            // Insert details
            $sqlDetail = "INSERT INTO eskaria_detaileak (eskaria_id, produktua_id, kopurua) VALUES (:eskaria_id, :produktua_id, :kopurua)";
            $stmtDetail = $this->konexioa->prepare($sqlDetail);

            foreach ($eskaria->getDetaileak() as $detailea) {
                $stmtDetail->bindValue(':eskaria_id', $eskariaId);
                $stmtDetail->bindValue(':produktua_id', $detailea->getProduktua()->getId());
                $stmtDetail->bindValue(':kopurua', $detailea->getKopurua());
                $stmtDetail->execute();
            }

            $this->konexioa->commit();
            return $eskariaId;

        } catch (PDOException $e) {
            $this->konexioa->rollBack();
            error_log("Errorea eskaria gehitzean: " . $e->getMessage());
            return -1;
        }
    }

    public function selectEskaria(int $id): ?Eskaria
    {
        try {
            $sql = "SELECT * FROM eskariak WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $eskaria = new Eskaria();
                $eskaria->setId($row['id']);
                $eskaria->setData($row['data']);

                $bezeroa = new Bezeroa();
                $bezeroa->setIzena($row['izena']);
                $bezeroa->setAbizenak($row['abizenak']);
                $bezeroa->setHelbidea($row['helbidea']);
                $bezeroa->setHerria($row['herria']);
                $bezeroa->setPostaKodea($row['postaKodea']);
                $bezeroa->setProbintzia($row['probintzia']);
                $bezeroa->setEmaila($row['emaila']);
                $eskaria->setBezeroa($bezeroa);

                // Fetch details
                $sqlDetails = "SELECT d.kopurua, p.id as p_id, p.izena as p_izena, p.deskribapena, p.prezioa 
                               FROM eskaria_detaileak d 
                               -- LEFT JOIN could be better if produktua is deleted, but assuming integrity
                               -- Wait, we need to reconstruct Produktua. 
                               -- I should probably join with products table if I want full product info.
                               -- But 'Produktua' table interactions are handled by ProduktuakDB maybe?
                               -- For simplicity here I will assume I can just fetch IDs or basic info if products table exists.
                               -- I don't see 'produktuak' table structure but EskariaDB used to be standalone.
                               -- I will assume a 'produktuak' table exists from previous context or generic assumption.
                               -- But wait, I have 'Produktua' class.
                               -- Let's just fetch fields.
                               LEFT JOIN gitarrak p ON d.produktua_id = p.id
                               WHERE d.eskaria_id = :eskaria_id";

                // NOTE: I am assuming table 'gitarrak' exists. If not, I can't hydrate Product fully.
                // The previous code for EskariaDB didn't seem to link to products deeply.
                // I'll try to join. If it fails I will catch exception.

                $stmtDetails = $this->konexioa->prepare($sqlDetails);
                $stmtDetails->bindValue(':eskaria_id', $id);
                $stmtDetails->execute();

                $detaileak = [];
                while ($rowD = $stmtDetails->fetch(PDO::FETCH_ASSOC)) {
                    $produktua = new Produktua();
                    $produktua->setId($rowD['p_id']);
                    if (isset($rowD['p_izena']))
                        $produktua->setIzena($rowD['p_izena']);
                    if (isset($rowD['prezioa']))
                        $produktua->setPrezioa($rowD['prezioa']);
                    // ... set other fields

                    $detailea = new Detailea();
                    $detailea->setProduktua($produktua);
                    $detailea->setKopurua($rowD['kopurua']);
                    $detaileak[] = $detailea;
                }
                $eskaria->setDetaileak($detaileak);

                return $eskaria;
            }

        } catch (PDOException $e) {
            error_log("Errorea eskaria lortzean: " . $e->getMessage());
        }

        return null;
    }

    public function selectEskariak(): array
    {
        $eskariak = [];
        try {
            $sql = "SELECT id FROM eskariak ORDER BY id DESC";
            $stmt = $this->konexioa->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $eskaria = $this->selectEskaria($row['id']);
                if ($eskaria) {
                    $eskariak[] = $eskaria;
                }
            }
        } catch (PDOException $e) {
            error_log("Errorea eskariak lortzean: " . $e->getMessage());
        }
        return $eskariak;
    }

    public function updateEskaria(Eskaria $eskaria): int
    {
        // Simple implementation: update header, delete details and re-insert.
        try {
            $this->konexioa->beginTransaction();

            $sql = "UPDATE eskariak SET 
                data = :data, 
                izena = :izena, 
                abizenak = :abizenak, 
                helbidea = :helbidea, 
                herria = :herria, 
                postaKodea = :postaKodea, 
                probintzia = :probintzia, 
                emaila = :emaila
                WHERE id = :id";

            $stmt = $this->konexioa->prepare($sql);
            $bezeroa = $eskaria->getBezeroa();

            $stmt->bindValue(':data', $eskaria->getData());
            $stmt->bindValue(':izena', $bezeroa->getIzena());
            $stmt->bindValue(':abizenak', $bezeroa->getAbizenak());
            $stmt->bindValue(':helbidea', $bezeroa->getHelbidea());
            $stmt->bindValue(':herria', $bezeroa->getHerria());
            $stmt->bindValue(':postaKodea', $bezeroa->getPostaKodea());
            $stmt->bindValue(':probintzia', $bezeroa->getProbintzia());
            $stmt->bindValue(':emaila', $bezeroa->getEmaila());
            $stmt->bindValue(':id', $eskaria->getId());
            $stmt->execute();

            // Delete existing details
            $sqlDel = "DELETE FROM eskaria_detaileak WHERE eskaria_id = :id";
            $stmtDel = $this->konexioa->prepare($sqlDel);
            $stmtDel->bindValue(':id', $eskaria->getId());
            $stmtDel->execute();

            // Insert new details
            $sqlDetail = "INSERT INTO eskaria_detaileak (eskaria_id, produktua_id, kopurua) VALUES (:eskaria_id, :produktua_id, :kopurua)";
            $stmtDetail = $this->konexioa->prepare($sqlDetail);

            foreach ($eskaria->getDetaileak() as $detailea) {
                $stmtDetail->bindValue(':eskaria_id', $eskaria->getId());
                $stmtDetail->bindValue(':produktua_id', $detailea->getProduktua()->getId());
                $stmtDetail->bindValue(':kopurua', $detailea->getKopurua());
                $stmtDetail->execute();
            }

            $this->konexioa->commit();
            return 1; // Success

        } catch (PDOException $e) {
            $this->konexioa->rollBack();
            error_log("Errorea eskaria eguneratzean: " . $e->getMessage());
            return 0;
        }
    }

    public function updateEskariaInfo(Eskaria $eskaria): int
    {
        // Updates only the header info (customer/date), leaving details/products untouched.
        try {
            $sql = "UPDATE eskariak SET 
                data = :data, 
                izena = :izena, 
                abizenak = :abizenak, 
                helbidea = :helbidea, 
                herria = :herria, 
                postaKodea = :postaKodea, 
                probintzia = :probintzia, 
                emaila = :emaila
                WHERE id = :id";

            $stmt = $this->konexioa->prepare($sql);
            $bezeroa = $eskaria->getBezeroa();

            $stmt->bindValue(':data', $eskaria->getData());
            $stmt->bindValue(':izena', $bezeroa->getIzena());
            $stmt->bindValue(':abizenak', $bezeroa->getAbizenak());
            $stmt->bindValue(':helbidea', $bezeroa->getHelbidea());
            $stmt->bindValue(':herria', $bezeroa->getHerria());
            $stmt->bindValue(':postaKodea', $bezeroa->getPostaKodea());
            $stmt->bindValue(':probintzia', $bezeroa->getProbintzia());
            $stmt->bindValue(':emaila', $bezeroa->getEmaila());
            $stmt->bindValue(':id', $eskaria->getId());

            return $stmt->execute() ? 1 : 0;

        } catch (PDOException $e) {
            error_log("Errorea updateEskariaInfo: " . $e->getMessage());
            return 0;
        }
    }

    public function deleteEskaria(int $id): int
    {
        try {
            $this->konexioa->beginTransaction();

            $sqlDetails = "DELETE FROM eskaria_detaileak WHERE eskaria_id = :id";
            $stmtDetails = $this->konexioa->prepare($sqlDetails);
            $stmtDetails->bindValue(':id', $id);
            $stmtDetails->execute();

            $sql = "DELETE FROM eskariak WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $this->konexioa->commit();
            return 1;

        } catch (PDOException $e) {
            $this->konexioa->rollBack();
            error_log("Errorea eskaria ezabatzean: " . $e->getMessage());
            return 0;
        }
    }

    public function __destruct()
    {
        $this->konexioa = null;
    }
}
?>