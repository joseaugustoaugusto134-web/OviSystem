<?php

namespace Source\Controller\Treatments;

use Source\Controller\Api;
use Source\Models\Treatment\Disease;

class Diseases extends Api
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
                "Os campos nome e data de início são obrigatórios",
                "error"
            )->back();
            return;
        }

        $disease = new Disease(
            null,
            $data["sheeps_id"],
            $data["name"],
            $data["start_date"],
            $data["end_date"],
            $data["situation"],
            $data["veterinarian"],
            $data["treatment"],
            $data["observation"]
        );

        if(!$disease->insert()){
            $this->call(500, "internal_server_error", $disease->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $disease->getId(),
            "sheeps_id" => $disease->getSheepsId(),
            "name" => $disease->getName(),
            "start_date" => $disease->getStartDate(),
            "end_date" => $disease->getEndDate(),
            "situation" => $disease->getSituation(),
            "veterinarian" => $disease->getVeterinarian(),
            "treatment" => $disease->getTreatment(),
            "observation" =>$disease->getObservation(),
            "active" => $disease->getActive()
        ];

        $this->call(201,"success","Doença inserida com sucesso","success")->back($response);
    }

     public function update (array $data): void
    {
       $json = json_decode(file_get_contents("php://input"), true);
       $data = array_merge($data, $json ?? []);

        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        if(!filter_var($data["diseaseId"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID da doença é obrigatório e deve ser um número inteiro",
                "error"
            )->back();
            return;
        }

        if(!$this->validate($data)){
            $this->call(
                400,
                "bad_request",
                "Os campos nome e data de ínicio são obrigatórios",
                "error"
            )->back();
            return;
        }

        $disease = new Disease(
            null,
            $data["sheeps_id"],
            $data["name"],
            $data["start_date"]
        );
      

        if(!$disease->updateById($data["flockId"])){
            $this->call(500, "internal_server_error", $disease->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $disease->getId(),
            "sheeps_id" => $disease->getSheepsId(),
            "name" => $disease->getName(),
            "start_date" => $disease->
            "active" => $disease->getActive()
        ];

        $this->call(200,"success","Lote atualizado com sucesso","success")->back($response);
    }

    public function listAll (array $data): void
    {
        if(!$this->authToken (2)){
            $this->call(
                401,
                "unauthorized",
                "Usuário não está autenticado (sem token ou token inválido).",
                "error")->back();
            return;
        }

        $disease = new Disease();
        $this->call(200,"success","Lista de lotes","success")->back($disease->selectAll());
    }

    public function validate (array $data): bool
    {
        if(!isset($data["name"]) || empty($data["name"]) || !isset($data["start_date"]) || empty($data["start_date"])) {
            return false;
        }
        return true;
    }
}