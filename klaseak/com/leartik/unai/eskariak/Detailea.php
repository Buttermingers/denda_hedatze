<?php
require_once __DIR__ . '/../produktuak/produktuak.php';

class Detailea
{
    private $produktua;
    private $kopurua;

    public function __construct()
    {
    }

    public function setProduktua(Produktua $produktua)
    {
        $this->produktua = $produktua;
    }

    public function getProduktua()
    {
        return $this->produktua;
    }

    public function setKopurua($kopurua)
    {
        $this->kopurua = $kopurua;
    }

    public function getKopurua()
    {
        return $this->kopurua;
    }

    public function getGuztira()
    {
        if ($this->produktua && $this->kopurua) {
            return $this->produktua->getPrezioa() * $this->kopurua;
        }
        return 0.0;
    }
}
?>