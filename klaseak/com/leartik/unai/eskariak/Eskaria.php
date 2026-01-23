<?php
require_once __DIR__ . '/../bezeroak/Bezeroa.php';
require_once __DIR__ . '/Detailea.php';

class Eskaria
{
    private $id;
    private $data;
    private $bezeroa;
    private $detaileak;

    public function __construct()
    {
        $this->detaileak = [];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setBezeroa(Bezeroa $bezeroa)
    {
        $this->bezeroa = $bezeroa;
    }

    public function getBezeroa()
    {
        return $this->bezeroa;
    }

    public function setDetaileak($detaileak)
    {
        $this->detaileak = $detaileak;
    }

    public function getDetaileak()
    {
        return $this->detaileak;
    }
}
?>