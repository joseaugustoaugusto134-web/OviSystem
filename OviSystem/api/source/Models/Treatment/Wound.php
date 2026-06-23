<?php

namespace Source\Models\Treatment;
use Source\Core\Model;
use Source\Core\Connect;

class Wound extends Model
{
    private ?int $id;
    private ?int $sheepsId;
    private ?string $description;
    private ?string $date;
    private ?string $location;
    private ?string $situation;
    private ?string $severity;
    private ?string $treatment;
    private ?string $observation;
    private ?int $active;

    public function __construct(?int $id = null, ?int $sheepsId = null, ?string $description = null, ?string $date = null, ?string $location = null, ?string $situation, ?string $severity = null,?string $treatment = null, ?string $observation = null, ?int $active = 1)
    {
        $this->id = $id;
    $this->sheepsId = $sheepsId;
    $this->description = $description;
    $this->date = $date;
    $this->location = $location;
    $this->situation = $situation;
    $this->severity = $severity;
    $this->treatment = $treatment;
    $this->observation = $observation;
    $this->active = $active;

    $this->table = "wounds";
    $this->primaryKey = "id";
    $this->fillable = ["sheepsId", "description", "date", "location", "situation", "severity" , "treatment" , "observation",  "active"];
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

    
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation($location): void
    {
        $this->location = $location;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation($situation): void
    {
        $this->situation = $situation;
    }

    public function getSeverity(): ?string
    {
        return $this->severity;
    }

    public function setSeverity($severity): void
    {
        $this->severity = $severity;
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