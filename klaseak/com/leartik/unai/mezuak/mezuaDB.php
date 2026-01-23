<?php

require_once __DIR__ . '/mezuak.php';


class MezuaDB
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

        } catch (PDOException $e) {
            die("Konexio errorea: " . $e->getMessage());
        }
    }

  public function gehitu(Mezua $mezua): bool
{
    try {
        $sql = "INSERT INTO mezuak (mezua, izena, emaila, erantzunda) 
                VALUES (:mezua, :izena, :emaila, :erantzunda)";
        $stmt = $this->konexioa->prepare($sql);

        $stmt->bindValue(':mezua', $mezua->getMezua());
        $stmt->bindValue(':izena', $mezua->getIzena());
        $stmt->bindValue(':emaila', $mezua->getEmaila());
        $stmt->bindValue(':erantzunda', $mezua->getErantzunda() ? 1 : 0, PDO::PARAM_INT);

        return $stmt->execute();

    } catch (PDOException $e) {
        error_log("Errorea mezua gehitzean: " . $e->getMessage());
        return false;
    }
}


    public function getMezuak(): array
    {
        $mezuak = [];

        try {
            $sql = "SELECT id, mezua, izena, emaila, erantzunda 
                    FROM mezuak ORDER BY id DESC";
            $stmt = $this->konexioa->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $mezua = new Mezua();
                $mezua->setId($row['id']);
                $mezua->setMezua($row['mezua']);
                $mezua->setIzena($row['izena']);
                $mezua->setEmaila($row['emaila']);
                $mezua->setErantzunda((bool)$row['erantzunda']);
                $mezuak[] = $mezua;
            }

        } catch (PDOException $e) {
            error_log("Errorea mezuak lortzean: " . $e->getMessage());
        }

        return $mezuak;
    }

    public function getMezuaById(int $id): ?Mezua
    {
        try {
            $sql = "SELECT id, mezua, izena, emaila, erantzunda 
                    FROM mezuak WHERE id = :id";

            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $mezua = new Mezua();
                $mezua->setId($row['id']);
                $mezua->setMezua($row['mezua']);
                $mezua->setIzena($row['izena']);
                $mezua->setEmaila($row['emaila']);
                $mezua->setErantzunda((bool)$row['erantzunda']);
                return $mezua;
            }

        } catch (PDOException $e) {
            error_log("Errorea mezua ID bidez lortzean ($id): " . $e->getMessage());
        }

        return null;
    }

    public function ezabatu(int $id): bool
    {
        try {
            $sql = "DELETE FROM mezuak WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Errorea mezua ezabatzean: " . $e->getMessage());
            return false;
        }
    }

    public function eguneratu(Mezua $mezua): bool
    {
        try {
            $sql = "UPDATE mezuak SET 
                    mezua = :mezua, 
                    izena = :izena, 
                    emaila = :emaila, 
                    erantzunda = :erantzunda 
                    WHERE id = :id";
            
            $stmt = $this->konexioa->prepare($sql);

            $stmt->bindValue(':mezua', $mezua->getMezua());
            $stmt->bindValue(':izena', $mezua->getIzena());
            $stmt->bindValue(':emaila', $mezua->getEmaila());
            $stmt->bindValue(':erantzunda', $mezua->getErantzunda() ? 1 : 0, PDO::PARAM_INT);
            $stmt->bindValue(':id', $mezua->getId(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Errorea mezua eguneratzean: " . $e->getMessage());
            return false;
        }
    }

    public function __destruct()
    {
        $this->konexioa = null;
    }
}

?>
