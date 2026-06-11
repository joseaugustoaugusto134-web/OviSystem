<?php

namespace Source\Models;
use Source\Core\Model;
use Source\Core\Connect;

class Flock extends Model
{
    private ?int $id;
    private ?int $userId;
    private ?string $name;
    private ?int $active;

    public function __construct(?int $id = null, ?int $userId = null, ?string $name = null, ?int $active = 1)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->active = $active;

        $this->table = "Flocks";
        $this->primaryKey = "id";
        $this->fillable = ["Users_Id", "Name", "Active"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
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