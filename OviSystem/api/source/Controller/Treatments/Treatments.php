<?php


namespace Source\Controller\Treatments;

use Source\Controller\Api;
use Source\Models\Treatment\Vaccine;

class Treatments extends Api
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
                "O campo type e start_date são obrigatórios",
                "error"
            )->back();
            return;
        }

        $treatment = new Treatment(
            null,
            $data["sheeps_id"],
            $data["type"],
            $data["start_date"],
            $data["end_date"],
            $data["medications"],
            $data["dose_frequency"],
            $data["veterinarian"],
            $data["observations"]
        );

        if(!$treatment->insert()){
            $this->call(500, "internal_server_error", $treatment->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $treatment->getId(),
            "sheeps_id" => $treatment->getSheepsId(),
            "type" => $treatment->getType(),
            "start_date" => $treatment->getStartDate(),
            "end_date" => $treatment->getEndDate(),
            "medications" => $treatment->getMedications(),
            "dose_frequency" => $treatment->getDoseFrequency(),
            "veterinarian" => $treatment->getVeterinarian(),
            "observations" =>$treatment->getObservations(),
            "active" => $treatment->getActive()
        ];

        $this->call(201,"success","Tratamento inserido com sucesso","success")->back($response);
    }


    public function validate (array $data): bool
    {
        if(!isset($data["type"]) || empty($data["type"]) || !isset($data["start_date"]) || empty($data["start_date"])) {
            return false;
        }
        return true;
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

        $treatment = new Treatment();
        $this->call(200,"success","Lista de tratamentos","success")->back($treatment->selectAll());
    }

    
}