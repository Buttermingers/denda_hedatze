<?php 

class Kategoria
{
    private ?int $id = null;
    private ?string $izena = null;
    private ?string $laburpena = null;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    
    public function getIzena(): ?string
    {
        return $this->izena;
    }

    
    public function setIzena(?string $izena)
    {
        $this->izena = $izena;
    }

    
    public function getLaburpena(): ?string
    {
        return $this->laburpena;
    }

    
    public function setLaburpena(?string $laburpena) 
    {
        $this->laburpena = $laburpena;
    }
}

?>