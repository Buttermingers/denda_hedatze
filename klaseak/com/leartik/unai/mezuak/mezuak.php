<?php 

class Mezua
{
    private ?int $id = null;
    private ?string $mezua = null;
    private ?string $izena = null;
    private ?string $emaila = null;
    private ?bool $erantzunda = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getMezua(): ?string
    {
        return $this->mezua;
    }

    public function setMezua(?string $mezua)
    {
        $this->mezua = $mezua;
    }

    public function getIzena(): ?string
    {
        return $this->izena;
    }

    public function setIzena(?string $izena)
    {
        $this->izena = $izena;
    }

    public function getEmaila(): ?string
    {
        return $this->emaila;
    }

    public function setEmaila(?string $emaila)
    {
        $this->emaila = $emaila;
    }

    public function getErantzunda(): ?bool
    {
        return $this->erantzunda;
    }

    public function setErantzunda(?bool $erantzunda)
    {
        $this->erantzunda = $erantzunda;
    }
}

?>
