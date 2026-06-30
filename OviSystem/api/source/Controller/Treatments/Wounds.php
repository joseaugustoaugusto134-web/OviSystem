<?php

namespace Source\Controller\Treatments;

use Source\Controller\Api;
use Source\Models\Treatment\Wound;

class Wounds extends Api
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
                "O campo vermífugo e data de aplicação é obrigatório",
                "error"
            )->back();
            return;
        }

        $wound = new Wound(
            null,
            $data["sheeps_id"],
            $data["description"],
            $data["date"],
            $data["location"],
            $data["situation"],
            $data["severity"],
            $data["treatment"],
            $data["observation"]
        );

        if(!$wound->insert()){
            $this->call(500, "internal_server_error", $wound->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $wound->getId(),
            "sheeps_id" => $wound->getSheepsId(),
            "vermifuge" => $wound->getVermifuge(),
            "aplication_date" => $wound->getAplicationDate(),
            "next_aplication" => $wound->getNextAplication(),
            "dose" => $wound->getDose(),
            "via" => $wound->getVia(),
            "aplicator" => $wound->getAplicator(),
            "observation" =>$wound->getObservation(),
            "active" => $wound->getActive()
        ];

        $this->call(201,"success","Ferida inserida com sucesso","success")->back($response);
    }

    public function validate (array $data): bool
    {
        if(!isset($data["description"]) || empty($data["description"]) || !isset($data["date"]) || empty($data["date"])) {
            return false;
        }
        return true;
    }
}