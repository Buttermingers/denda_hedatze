<?php

class Produktua
{
    private $id;
    private $izena;
    private $deskribapena;
    private $prezioa;
    private $kategoria_id;
    private $irudia;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIzena()
    {
        return $this->izena;
    }

    public function setIzena($izena)
    {
        $this->izena = $izena;
    }

    public function getDeskribapena()
    {
        return $this->deskribapena;
    }

    public function setDeskribapena($deskribapena)
    {
        $this->deskribapena = $deskribapena;
    }

    public function getPrezioa()
    {
        return $this->prezioa;
    }

    public function setPrezioa($prezioa)
    {
        $this->prezioa = $prezioa;
    }

    public function getKategoriaId()
    {
        return $this->kategoria_id;
    }

    public function setKategoriaId($kategoria_id)
    {
        $this->kategoria_id = $kategoria_id;
    }

    public function getIrudia()
    {
        return $this->irudia;
    }

    public function setIrudia($irudia)
    {
        $this->irudia = $irudia;
    }

    private $ofertas;
    private $novedades;
    private $descuento;

    public function getOfertas()
    {
        return $this->ofertas;
    }

    public function setOfertas($ofertas)
    {
        $this->ofertas = $ofertas;
    }

    public function getNovedades()
    {
        return $this->novedades;
    }

    public function setNovedades($novedades)
    {
        $this->novedades = $novedades;
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'izena' => $this->izena,
            'deskribapena' => $this->deskribapena,
            'prezioa' => $this->prezioa,
            'kategoria_id' => $this->kategoria_id,
            'irudia' => $this->irudia,
            'ofertas' => $this->ofertas,
            'novedades' => $this->novedades,
            'descuento' => $this->descuento
        ];
    }
}

?>