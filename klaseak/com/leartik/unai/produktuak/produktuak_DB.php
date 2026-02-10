<?php

require_once __DIR__ . '/produktuak.php';

class ProduktuaDB
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

    private function mapProduktua(array $row): Produktua
    {
        $produktua = new Produktua();
        $produktua->setId($row['id']);
        $produktua->setIzena($row['izena']);
        $produktua->setDeskribapena($row['deskribapena']);
        $produktua->setPrezioa($row['prezioa']);
        $produktua->setIrudia($row['irudia']);
        $produktua->setKategoriaId($row['kategoria_id']);
        $produktua->setOfertas($row['ofertas']);
        $produktua->setNovedades($row['novedades']);
        $produktua->setDescuento($row['descuento']);
        return $produktua;
    }

    public function getProduktuak(): array
    {
        $produktuak = [];

        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia, 
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak";

            $stmt = $this->konexioa->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produktuak[] = $this->mapProduktua($row);
            }

        } catch (PDOException $e) {
            error_log("Errorea produktuak lortzean: " . $e->getMessage());
        }

        return $produktuak;
    }

    public function getProduktuakByKategoria(int $kategoria_id): array
    {
        $produktuak = [];

        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia,
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak
                    WHERE kategoriak_ID = :kategoria_id";

            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':kategoria_id', $kategoria_id);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produktuak[] = $this->mapProduktua($row);
            }

        } catch (PDOException $e) {
            error_log("Errorea kategoriaren produktuak lortzean: " . $e->getMessage());
        }

        return $produktuak;
    }

    public function getProduktuaById(int $id): ?Produktua
    {
        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia,
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak
                    WHERE id = :id";

            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row ? $this->mapProduktua($row) : null;

        } catch (PDOException $e) {
            error_log("Errorea produktua lortzean ID-arekin ($id): " . $e->getMessage());
            return null;
        }
    }

    public function gehitu(Produktua $produktua): bool
    {
        try {
            $sql = "INSERT INTO gitarrak 
                    (izena, deskribapena, prezioa, irudia, kategoriak_ID, ofertas, novedades, descuento)
                    VALUES 
                    (:izena, :deskribapena, :prezioa, :irudia, :kategoria_id, :ofertas, :novedades, :descuento)";

            $stmt = $this->konexioa->prepare($sql);

            $stmt->bindValue(':izena', $produktua->getIzena());
            $stmt->bindValue(':deskribapena', $produktua->getDeskribapena());
            $stmt->bindValue(':prezioa', $produktua->getPrezioa());
            $stmt->bindValue(':irudia', $produktua->getIrudia());
            $stmt->bindValue(':kategoria_id', $produktua->getKategoriaId());
            $stmt->bindValue(':ofertas', $produktua->getOfertas());
            $stmt->bindValue(':novedades', $produktua->getNovedades());
            $stmt->bindValue(':descuento', $produktua->getDescuento());

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Errorea produktua gehitzean: " . $e->getMessage());
            return false;
        }
    }

    public function aldatu(Produktua $produktua): bool
    {
        try {
            $sql = "UPDATE gitarrak SET 
                        izena = :izena,
                        deskribapena = :deskribapena,
                        prezioa = :prezioa,
                        irudia = :irudia,
                        kategoriak_ID = :kategoria_id,
                        ofertas = :ofertas,
                        novedades = :novedades,
                        descuento = :descuento
                    WHERE id = :id";

            $stmt = $this->konexioa->prepare($sql);

            $stmt->bindValue(':id', $produktua->getId());
            $stmt->bindValue(':izena', $produktua->getIzena());
            $stmt->bindValue(':deskribapena', $produktua->getDeskribapena());
            $stmt->bindValue(':prezioa', $produktua->getPrezioa());
            $stmt->bindValue(':irudia', $produktua->getIrudia());
            $stmt->bindValue(':kategoria_id', $produktua->getKategoriaId());
            $stmt->bindValue(':ofertas', $produktua->getOfertas());
            $stmt->bindValue(':novedades', $produktua->getNovedades());
            $stmt->bindValue(':descuento', $produktua->getDescuento());

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Errorea produktua aldatzean: " . $e->getMessage());
            return false;
        }
    }

    public function ezabatu(int $id): bool
    {
        try {
            $sql = "DELETE FROM gitarrak WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Errorea produktua ezabatzean ID-arekin ($id): " . $e->getMessage());
            return false;
        }
    }

    public function getAzkenProduktuak(int $limit = 3): array
    {
        $produktuak = [];

        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia,
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak
                    ORDER BY id DESC
                    LIMIT :lim";

            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produktuak[] = $this->mapProduktua($row);
            }

        } catch (PDOException $e) {
            error_log("Errorea azken produktuak lortzean: " . $e->getMessage());
        }

        return $produktuak;
    }

    public function getOfertas(): array
    {
        $produktuak = [];

        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia,
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak
                    WHERE ofertas = 1";

            $stmt = $this->konexioa->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produktuak[] = $this->mapProduktua($row);
            }

        } catch (PDOException $e) {
            error_log("Errorea eskaintzak lortzean: " . $e->getMessage());
        }

        return $produktuak;
    }

    public function getNovedades(): array
    {
        $produktuak = [];

        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia,
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak
                    WHERE novedades = 1";

            $stmt = $this->konexioa->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produktuak[] = $this->mapProduktua($row);
            }

        } catch (PDOException $e) {
            error_log("Errorea berrien produktuak lortzean: " . $e->getMessage());
        }

        return $produktuak;
    }

    public function searchProduktuak(string $term): array
    {
        $produktuak = [];
        $term = "%" . $term . "%";

        try {
            $sql = "SELECT id, izena, deskribapena, prezioa, irudia,
                           kategoriak_ID AS kategoria_id, ofertas, novedades, descuento
                    FROM gitarrak
                    WHERE izena LIKE :term OR deskribapena LIKE :term";

            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':term', $term);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produktuak[] = $this->mapProduktua($row);
            }

        } catch (PDOException $e) {
            error_log("Errorea produktuak bilatzean: " . $e->getMessage());
        }

        return $produktuak;
    }

    public function __destruct()
    {
        $this->konexioa = null;
    }
}
