<?php

namespace Source\Controller\Treatments;

use Source\Controller\Api;
use Source\Models\Treatment\Vaccine;

class Vaccines extends Api
{
    public function insert (array $data): void
    {
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!$this->validate($data)){
            $this->call(
                400,
                "bad_request",
                "O campo nome é obrigatório",
                "error"
            )->back();
            return;
        }

        $vaccine = new Vaccine(
            null,
            $data["sheeps_id"],
            $data["name"],
            $data["aplication_date"],
            $data["dose"],
            $data["aplicator"],
            $data["observation"]
        );

        if(!$vaccine->insert()){
            $this->call(500, "internal_server_error", $vaccine->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $vaccine->getId(),
            "users_id" => $vaccine->getSheepsId(),
            "name" => $vaccine->getName(),
            "aplication_date" => $vaccine->getAplicationDate(),
            "dose" => $vaccine->getDose(),
            "aplicator" => $vaccine->getAplicator(),
            "observation" =>$vaccine->getObservation(),
            "active" => $vaccine->getActive()
        ];

        $this->call(201,"success","Vacina inserida com sucesso","success")->back($response);
    }

    public function validate (array $data): bool
    {
        if(!isset($data["name"]) || empty($data["name"])) {
            return false;
        }
        return true;
    }
}