<?php

namespace Source\Models;
use Source\Core\Model;
use Source\Core\Connect;

class Flock extends Model
{
    private ?int $id;
    private ?int $usersId;
    private ?string $name;
    private ?int $active;

    public function __construct(?int $id = null, ?int $usersId = null, ?string $name = null, ?int $active = 1)
    {
        $this->id = $id;
        $this->usersId = $usersId;
        $this->name = $name;
        $this->active = $active;

        $this->table = "flocks";
        $this->primaryKey = "id";
        $this->fillable = ["usersId", "name", "active"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUsersId(): ?int
    {
        return $this->usersId;
    }

    public function setUsersId($usersId): void
    {
        $this->usersId = $usersId;
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