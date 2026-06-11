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

public function update (array $data): void
    {
       $json = json_decode(file_get_contents("php://input"), true);
       $data = array_merge($data, $json ?? []);

        if(!filter_var($data["usersId"], FILTER_VALIDATE_INT)) {
            $this->call(
                400,
                "bad_request",
                "ID do usuário é obrigatório e deve ser um número inteiro",
                "error"
            )->back();
            return;
        }

        if(!$this->validate($data)){
            $this->call(
                400,
                "bad_request",
                "O campo Name é obrigatório",
                "error"
            )->back();
            return;
        }

        $flock = new Flock(
            null,
            $data["usersId"],
            $data["Name"]
        );
      

        if(!$faq->updateById($data["usersId"])){
            $this->call(500, "internal_server_error", $faq->getErrorMessage(), "error")->back();
            return;
        }
        $response = [
            "id" => $flock->getId(),
            "faqsCategoryId" => $flock->getUsersId(),
            "question" => $flock->getName(),
            "active" => $flock->getActive()
        ];

        $this->call(200,"success","Lote atualizado com sucesso","success")->back($response);
    }
}
