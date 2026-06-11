<?php

namespace Source\Controller;

use Source\Controller\Api;
use Source\Models\Flock;

class Flocks extends Api
{
    public function insert (array $data): void
    {
        if(!$this->validate($data)){
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back();
            return;
        }

        $flock = new Flock(
            null,
            $data["Users_Id"],
            $data["Name"]
        );

        if(!$flock->insert()){
            $this->call(500, "internal_server_error", $flock->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $flock->getId(),
            "user_Id" => $flock->getUserId(),
            "name" => $flock->getName(),
            "active" => $flock->getActive()
        ];

        $this->call(201,"success","Lote inserido com sucesso","success")->back($response);

    }

    public function validate (array $data): bool
    {
        if(!isset($data["user_Id"]) || !isset($data["name"]) ||
            empty($data["user_Id"]) || empty($data["name"]) ||
           !filter_var($data["user_Id"], FILTER_VALIDATE_INT)) {
            return false;
        }
        return true;
    }
}