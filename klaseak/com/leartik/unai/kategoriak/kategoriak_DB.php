<?php

require_once __DIR__ . '/kategoriak.php'; 

class KategoriaDB
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

    public function gehitu(Kategoria $kategoria): bool
    {
        try {
            $sql = "INSERT INTO kategoriak (izena, laburpena) VALUES (:izena, :laburpena)";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':izena', $kategoria->getIzena());
            $stmt->bindValue(':laburpena', $kategoria->getLaburpena());
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Errorea kategoria gehitzean: " . $e->getMessage());
            return false;
        }
    }

    public function getKategoriak(): array
    {
        $kategoriak = [];
        try {
            $sql = "SELECT id, izena, laburpena FROM kategoriak ORDER BY izena";
            $stmt = $this->konexioa->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $kategoria = new Kategoria();
                $kategoria->setId($row['id']);
                $kategoria->setIzena($row['izena']);
                $kategoria->setLaburpena($row['laburpena']);
                $kategoriak[] = $kategoria;
            }
        } catch (PDOException $e) {
            error_log("Errorea kategoriak lortzean: " . $e->getMessage());
        }
        return $kategoriak;
    }

    public function getKategoriaById(int $id): ?Kategoria
    {
        try {
            $sql = "SELECT id, izena, laburpena FROM kategoriak WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $kategoria = new Kategoria();
                $kategoria->setId($row['id']);
                $kategoria->setIzena($row['izena']);
                $kategoria->setLaburpena($row['laburpena']);
                return $kategoria;
            }
        } catch (PDOException $e) {
            error_log("Errorea kategoria lortzean ID-arekin ($id): " . $e->getMessage());
        }
        return null;
    }

    public function aldatu(Kategoria $kategoria): bool
    {
        try {
            $sql = "UPDATE kategoriak SET izena = :izena, laburpena = :laburpena WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $kategoria->getId());
            $stmt->bindValue(':izena', $kategoria->getIzena());
            $stmt->bindValue(':laburpena', $kategoria->getLaburpena());
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Errorea kategoria aldatzean: " . $e->getMessage());
            return false;
        }
    }

    public function ezabatu(int $id): bool
    {
        try {
            $sql = "DELETE FROM kategoriak WHERE id = :id";
            $stmt = $this->konexioa->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Errorea kategoria ezabatzean: " . $e->getMessage());
            return false;
        }
    }

    public function __destruct()
    {
        $this->konexioa = null;
    }
}