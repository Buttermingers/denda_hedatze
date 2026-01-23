<?php

class Bezeroa {
    private $izena;
    private $abizenak;
    private $helbidea;
    private $herria;
    private $postaKodea;
    private $probintzia;
    private $emaila;

    public function __construct() {
    }

    public function setIzena($izena) {
        $this->izena = $izena;
    }

    public function getIzena() {
        return $this->izena;
    }

    public function setAbizenak($abizenak) {
        $this->abizenak = $abizenak;
    }

    public function getAbizenak() {
        return $this->abizenak;
    }

    public function setHelbidea($helbidea) {
        $this->helbidea = $helbidea;
    }

    public function getHelbidea() {
        return $this->helbidea;
    }

    public function setHerria($herria) {
        $this->herria = $herria;
    }

    public function getHerria() {
        return $this->herria;
    }

    public function setPostaKodea($postaKodea) {
        $this->postaKodea = $postaKodea;
    }

    public function getPostaKodea() {
        return $this->postaKodea;
    }

    public function setProbintzia($probintzia) {
        $this->probintzia = $probintzia;
    }

    public function getProbintzia() {
        return $this->probintzia;
    }

    public function setEmaila($emaila) {
        $this->emaila = $emaila;
    }

    public function getEmaila() {
        return $this->emaila;
    }
}
?>
