<?php

namespace Source\Controller\Treatments;

use Source\Controller\Api;
use Source\Models\Treatment\Deworming;

class Deworming extends Api
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

        $deworming = new Deworming(
            null,
            $data["sheeps_id"],
            $data["vermifuge"],
            $data["aplication_date"],
            $data["next_aplication"],
            $data["dose"],
            $data["via"],
            $data["aplicator"],
            $data["observation"]
        );

        if(!$deworming->insert()){
            $this->call(500, "internal_server_error", $deworming->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $deworming->getId(),
            "sheeps_id" => $deworming->getSheepsId(),
            "vermifuge" => $deworming->getVermifuge(),
            "aplication_date" => $deworming->getAplicationDate(),
            "next_aplication" => $deworming->getNextAplication(),
            "dose" => $deworming->getDose(),
            "via" => $deworming->getVia(),
            "aplicator" => $deworming->getAplicator(),
            "observation" =>$deworming->getObservation(),
            "active" => $deworming->getActive()
        ];

        $this->call(201,"success","Vermifugação inserida com sucesso","success")->back($response);
    }

    public function validate (array $data): bool
    {
        if(!isset($data["vermifuge"]) || empty($data["vermifuge"]) || !isset($data["aplication_date"]) || empty($data["aplication_date"])) {
            return false;
        }
        return true;
    }
}