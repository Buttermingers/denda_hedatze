<?php
require_once __DIR__ . '/Detailea.php';

class Saskia
{
    private $detaileak;

    public function __construct()
    {
        $this->detaileak = [];
    }

    public function setDetaileak($detaileak)
    {
        $this->detaileak = $detaileak;
    }

    public function getDetaileak()
    {
        return $this->detaileak;
    }

    public function detaileaGehitu(Detailea $detailea)
    {

        foreach ($this->detaileak as $d) {
            if ($d->getProduktua()->getId() == $detailea->getProduktua()->getId()) {
                $d->setKopurua($d->getKopurua() + $detailea->getKopurua());
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $this->detaileak[] = $detailea;
        }
    }

    public function detaileaAldatu(Detailea $detailea)
    {
        foreach ($this->detaileak as $d) {
            if ($d->getProduktua()->getId() == $detailea->getProduktua()->getId()) {
                $d->setKopurua($detailea->getKopurua());
                break;
            }
        }
    }

    public function detaileaEzabatu(Detailea $detailea)
    {
        foreach ($this->detaileak as $key => $d) {
            if ($d->getProduktua()->getId() == $detailea->getProduktua()->getId()) {
                unset($this->detaileak[$key]);
                $this->detaileak = array_values($this->detaileak);
                break;
            }
        }
    }

    public function getDetaileKopurua()
    {
        return count($this->detaileak);
    }

    public function getGuztira()
    {
        $guztira = 0;
        foreach ($this->detaileak as $detailea) {
            $guztira += $detailea->getGuztira();
        }
        return $guztira;
    }
}
?>