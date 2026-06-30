<?php

namespace Source\Models\Treatment;
use Source\Core\Model;
use Source\Core\Connect;


class Treatment extends Model
{

    private ?int $id;
    private ?int $sheepsId;
    private ?string $type;
    private ?string $startDate;
    private ?string $endDate;
    private ?string $medications;
    private ?string $doseFrequency;
    private ?string $veterinarian;
    private ?string $observations;
    private ?int $active;


    public function __construct(?int $id = null, ?int $sheepsId = null, ?string $type = null,?string $startDate = null, ?string $endDate = null, ?string $medications = null, ?string $doseFrequency = null, ?string $veterinarian = null, ?string $observations = null, ?int $active = 1)
    {
    $this->id = $id;
    $this->sheepsId = $sheepsId;
    $this->type = $type;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->medications = $medications;
    $this->doseFrequency = $doseFrequency;
    $this->veterinarian = $veterinarian;
    $this->observations = $observations;
    $this->active = $active;


    $this->table = "treatment";
    $this->primaryKey = "id";
    $this->fillable = ["sheepsId", "startDate", "endDate", "medications", "doseFrequency", "veterinarian" , "observations", "active"];
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


     public function getType(): ?string
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
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

    public function getMedications(): ?string
    {
        return $this->medications;
    }

    public function setMedications(): void
    {
        $this->medications = $medications;
    }

    public function getDoseFrequency(): ?string
    {
        return $this->doseFrequency;
    }

    public function setDoseFrequency(): void
    {
        $this->doseFrequency = $doseFrequency;
    }

    public function getVeterinarian(): ?string
    {
        return $this->veterinarian;
    }

    public function setVeterinarian(): void
    {
        $this->veterinarian = $veterinarian;
    }

     public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations($observations): void
    {
        $this->observations = $observations;
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