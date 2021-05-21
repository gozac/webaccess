<?php
// src/Entity/Lead.php
namespace App\Entity;

class Lead
{
    protected $name;
    protected $yolo;
    protected $adressemail;
    protected $content;
    protected $Date;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getYolo(): ?string
    {
        return $this->yolo;
    }

    public function setYolo(string $yolo): void
    {
        $this->$yolo = $yolo;
    }

    public function getAdressemail(): ?string
    {
        return $this->adressemail;
    }

    public function setAdressemail(string $adressemail): void
    {
        $this->$adressemail = $adressemail;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getDate(): ?\DateTime
    {
        return $this->Date;
    }

    public function setDate(?\DateTime $Date): void
    {
        $this->Date = $Date;
    }
}
