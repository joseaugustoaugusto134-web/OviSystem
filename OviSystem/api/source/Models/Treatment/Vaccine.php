<?php

namespace Source\Models\Treatment;
use Source\Core\Model;
use Source\Core\Connect;

class Vaccine extends Model
{

    private ?int $id;
    private ?int $sheepsId;
    private ?string $name;
    private ?string $aplicationDate;
    private ?string $dose;
    private ?string $aplicator;
    private ?string $observation;
    private ?int $active;
    
    public function __construct(?int $id = null,?int $sheepsId = null,?string $name = null, ?string $aplicationDate = null, ?string $dose = null, ?string $aplicator = null, ?string $observation = null, ?int $active = 1 )
    {
    $this->id = $id;
    $this->sheepsId = $sheepsId;
    $this->name = $name;
    $this->aplicationDate = $aplicationDate;
    $this->dose = $dose;
    $this->aplicator = $aplicator;
    $this->observation = $observation;
    $this->active = $active;

    $this->table = "vaccines";
    $this->primaryKey = "id";
    $this->fillable = ["sheepsId", "name", "aplicationDate", "dose", "aplicator", "observation",  "active"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getSheepsId(): ?int
    {
        return $this->sheepsId;
    }

    public function setId($sheepsId): void
    {
        $this->sheepsId = $sheepsId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getAplicationDate(): ?string
    {
        return $this->aplicationDate;
    }

    public function setAplicationDate($aplicationDate): void
    {
        $this->aplicationDate = $aplicationDate;
    }
    
    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose($dose): void
    {
        $this->dose = $dose;
    }
    
    public function getAplicator(): ?string
    {
        return $this->aplicator;
    }

    public function setAplicationDate($aplicator): void
    {
        $this->aplicator = $aplicator;
    }
    
    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation($observation): void
    {
        $this->observation = $observation;
    }
    
    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }
}
