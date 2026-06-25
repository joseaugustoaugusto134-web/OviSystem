<?php

namespace Source\Models\Treatment;
use Source\Core\Model;
use Source\Core\Connect;

class Disease extends Model
{
    private ?int $id;
    private ?int $sheepsId;
    private ?string $name;
    private ?string $startDate;
    private ?string $endDate;
    private ?string $situation;
    private ?string $veterinarian;
    private ?string $treatment;
    private ?string $observation;
    private ?int $active;


    public function __construct(?int $id = null, ?int $sheepsId = null, ?string $name = null, ?string $startDate = null, ?string $endDate = null, ?string $situation = null, ?string $veterinarian = null, ?string $treatment = null, ?string $observation = null, ?int $active = 1 )
    {

    $this->id = $id;
    $this->sheepsId = $sheepsId;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->situation = $situation;
    $this->veterinarian = $veterinarian;
    $this->treatment = $treatment;
    $this->observation = $observation;
    $this->active = $active;


    $this->table = "disease";
    $this->primaryKey = "id";
    $this->fillable = ["sheepsId", "startDate", "endDate", "situation", "veterinarian" ,"treatment", "observation",  "active"];
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


     public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation($situation): void
    {
        $this->situation = $situation;
    }

    public function getVeterinarian(): ?string
    {
        return $this->veterinarian;
    }

    public function setVeterinarian($veterinarian): void
    {
        $this->veterinarian = $veterinarian;
    }

    public function getTreatment(): ?string
    {
        return $this->treatment;
    }

    public function setTreatment($treatment): void
    {
        $this->treatment = $treatment;
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