<?php

namespace Source\Models\Treatment;
use Source\Core\Model;
use Source\Core\Connect;

class Deworming extends Model
{
    private ?int $id;
    private ?int $sheepsId;
    private ?string $vermifuge;
    private ?string $nextAplication;
    private ?string $dose;
    private ?string $via;
    private ?string $aplicator;
    private ?string $observation;
    private ?int $active;

    public function __construct(?int $id = null, ?int $sheepsId = null, ?string $vermifuge = null, ?string $nextAplication = null, ?string $dose = null, ?string $via = null, ?string $aplicator = null ,?string $observation = null,?int $active = 1)
    {
        $this->id = $id;
        $this->sheepsId = $sheepsId;
        $this->vermifuge = $vermifuge;
        $this->nextAplication = $nextAplication;
        $this->dose = $dose;
        $this->via = $via;
        $this->aplicator = $aplicator;
        $this->observation = $observation;
        $this->active = $active;

        
    $this->table = "deworming";
    $this->primaryKey = "id";
    $this->fillable = ["sheepsId", "vermifuge", "nextAplication", "dose", "via" ,"aplicator", "observation",  "active"];

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

    public function setSheepsId($sheepsId): void
    {
        $this->sheepsId = $sheepsId;
    }

      public function getVermifuge(): ?string
    {
        return $this->vermifuge;
    }

    public function setVermifuge($vermifuge): void
    {
        $this->vermifuge = $vermifuge;
    }

    public function getNextAplication(): ?string
    {
        return $this->nextAplication;
    }

    public function setNextAplication($nextAplication): void
    {
        $this->nextAplication = $nextAplication;
    }

    
    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose($dose): void
    {
        $this->dose = $dose;
    }
    
    public function getVia(): ?string
    {
        return $this->via;
    }

    public function setVia($via): void
    {
        $this->via = $via;
    }

    public function getAplicator(): ?string
    {
        return $this->aplicator;
    }

    public function setAplicator($aplicator): void
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