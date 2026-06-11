<?php

namespace source\Models;

use source\core\Connect;
use source\core\Model;

class Sheep extends Model
{
    private ?int $id;
    private ?int $flockId;
    private ?int $motherId;
    private ?int $fatherId;
    private ?int $number;
    private ?string $earTag;
    private ?string $sex;
    private ?int $pregnancy;
    private ?string $birthDate;
    private ?string $breed;
    private ?int $active;

    public function __construct(?int $id = null, ?int $flockId = null, ?int $motherId = null, ?int $fatherId = null, ?int $number = null, ?string $earTag = null, ?string $sex = null, ?int $pregnancy = 0, ?string $birthDate = null, ?string $breed = null, ?int $active = 1)
    {
        $this->id = $id;
        $this->flockId = $flockId;
        $this->motherId = $motherId;
        $this->fatherId = $fatherId;
        $this->number = $number;
        $this->earTag = $earTag;
        $this->sex = $sex;
        $this->pregnancy = $pregnancy;
        $this->birthDate = $birthDate;
        $this->breed = $breed;
        $this->active = $active;

        $this->table = "Sheeps";
        $this->primaryKey = "id";
        $this->fillable = ["flockId", "motherId", "fatherId", "number", "earTag", "sex", "pregnancy", "birthDate", "breed", "active"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getFlockId(): ?int
    {
        return $this->flockId;
    }

    public function setFlockId($flockId): void
    {
        $this->flockId = $flockId;
    }

    public function getMotherId(): ?int
    {
        return $this->motherId;
    }

    public function setMotherId($motherId): void
    {
        $this->motherId = $motherId;
    }

    public function getFatherId(): ?int
    {
        return $this->fatherId;
    }

    public function setFatherId($fatherId): void
    {
        $this->fatherId = $fatherId;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber($number): void
    {
        $this->number = $number;
    }

    public function getEarTag(): ?string
    {
        return $this->earTag;
    }

    public function setEarTag($earTag): void
    {
        $this->earTag = $earTag;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    public function getPregnancy(): ?int
    {
        return $this->pregnancy;
    }

    public function setPregnancy($pregnancy): void
    {
        $this->pregnancy = $pregnancy;
    }

    public function getBirthDate(): ?string
    {
        return $this->birhDate;
    }

    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed($breed): void
    {
        $this->breed = $breed;
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
