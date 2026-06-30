# OviSystem — Web Service (API)

API REST do OviSystem, responsável por fornecer dados tanto para o front-end web do sistema quanto para a Aplicação Mobile desenvolvida na disciplina de Programação de Dispositivos Móveis.

A API foi construída em PHP, utilizando o roteador [CoffeeCode Router](https://github.com/standsoftwarelabs/coffeecode-router) e autenticação via **JSON Web Tokens (JWT)**, com a biblioteca [firebase/php-jwt](https://github.com/firebase/php-jwt).

URL base (ambiente de desenvolvimento):

```
http://localhost/OviSystem/api
```

## Sumário

- [Formato padrão de resposta](#formato-padrão-de-resposta)
- [Autenticação](#autenticação)
- [Entidade: Usuários (`/users`)](#entidade-usuários-users)
- [Entidade: Lotes — Flocks (`/Flocks`)](#entidade-lotes--flocks-flocks)
- [Entidade: Ovelhas — Sheeps (`/Sheeps`)](#entidade-ovelhas--sheeps-sheeps)
- [Códigos de status HTTP utilizados](#códigos-de-status-http-utilizados)
- [Como rodar localmente](#como-rodar-localmente)

## Formato padrão de resposta

Toda resposta da API segue a mesma estrutura JSON, retornada pelo método `Api::call()`:

```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Mensagem descritiva da operação",
  "data": { }
}
```

| Campo     | Descrição                                                                 |
|-----------|-----------------------------------------------------------------------------|
| `code`    | Código HTTP da resposta (também enviado no header HTTP).                   |
| `type`    | `success` ou `error`.                                                       |
| `status`  | Identificador textual do status (`bad_request`, `unauthorized`, `not_found`, `internal_server_error`, `success`...). |
| `message` | Mensagem legível descrevendo o resultado da operação.                       |
| `data`    | Presente apenas quando a operação retorna dados (objeto ou array). Omitido em respostas sem conteúdo. |

## Autenticação

Rotas protegidas exigem um token JWT, obtido após login (`/users/login` ou `/users/login-admin`).

O token deve ser enviado em um dos seguintes headers, em toda requisição às rotas autenticadas:

```
Authorization: Bearer {token}
```

ou, alternativamente:

```
token: {token}
```

Características do token:

- Algoritmo: `HS512`
- Validade: **90 minutos** a partir da emissão
- Payload (`data`) contém `id`, `name` e `email` do usuário autenticado
- Tipos de usuário (`type_id`): `1` = administrador, `2` = usuário comum (produtor)

Caso o token esteja ausente, expirado, mal formado, ou o usuário não tenha o `type_id` exigido pela rota, a API responde:

```json
{
  "code": 401,
  "type": "error",
  "status": "unauthorized",
  "message": "Usuário não está autenticado (sem token ou token inválido)."
}
```

> Todas as rotas de `Flocks` e `Sheeps` exigem token de usuário comum (`type_id = 2`).

## Entidade: Usuários (`/users`)

### Registrar usuário comum
`POST /users/register`

Cria um novo usuário com `type_id = 2`. Não exige autenticação.

**Body (JSON):**
```json
{
  "name": "João da Silva",
  "email": "joao@email.com",
  "password": "minhaSenha123"
}
```

**Resposta 201:**
```json
{
  "code": 201,
  "type": "created",
  "status": "success",
  "message": "Usuário inserido com sucesso",
  "data": {
    "id": 4,
    "name": "João da Silva",
    "email": "joao@email.com"
  }
}
```

**Erros possíveis:**
- `400 bad_request` — senha ausente, nome/e-mail ausentes ou e-mail inválido.
- `500 internal_server_error` — e-mail já cadastrado, ou falha ao inserir no banco.

### Login de usuário comum
`POST /users/login`

**Body (JSON):**
```json
{
  "email": "joao@email.com",
  "password": "minhaSenha123"
}
```

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Usuário logado com sucesso",
  "data": {
    "id": 4,
    "name": "João da Silva",
    "photo": "",
    "token": "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9..."
  }
}
```

**Erros possíveis:**
- `400 bad_request` — e-mail/senha ausentes ou e-mail inválido.
- `401 unauthorized` — e-mail não cadastrado ou senha incorreta.

### Login de administrador
`POST /users/login-admin`

Idêntico ao login comum, porém valida o usuário contra `type_id = 1`. Mesmo formato de body e resposta do endpoint anterior.

## Entidade: Lotes — Flocks (`/Flocks`)

Representa os lotes (agrupamentos) de ovelhas pertencentes a um produtor. Todas as rotas abaixo exigem autenticação (`type_id = 2`).

### Criar lote
`POST /Flocks`

**Headers:** `Authorization: Bearer {token}`

**Body (JSON):**
```json
{
  "users_id": 4,
  "name": "Lote A — Matrizes"
}
```

**Resposta 201:**
```json
{
  "code": 201,
  "type": "success",
  "status": "success",
  "message": "Lote inserido com sucesso",
  "data": {
    "id": 7,
    "users_id": 4,
    "name": "Lote A — Matrizes",
    "active": 1
  }
}
```

**Erros possíveis:**
- `400 bad_request` — campo `name` ausente ou vazio.
- `401 unauthorized` — token ausente/inválido.
- `500 internal_server_error` — falha ao inserir no banco.

### Listar todos os lotes
`GET /Flocks`

**Headers:** `Authorization: Bearer {token}`

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Lista de lotes",
  "data": [
    { "id": 7, "users_id": 4, "name": "Lote A — Matrizes", "active": 1 },
    { "id": 8, "users_id": 4, "name": "Lote B — Recria", "active": 1 }
  ]
}
```

### Buscar lote por ID
`GET /Flocks/{flockId}`

**Headers:** `Authorization: Bearer {token}`

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Lote encontrado",
  "data": { "id": 7, "users_id": 4, "name": "Lote A — Matrizes", "active": 1 }
}
```

**Erros possíveis:**
- `400 bad_request` — `flockId` ausente ou não numérico.
- `404 not_found` — nenhum lote com o ID informado.

### Atualizar lote
`PUT /Flocks/{flockId}`

**Headers:** `Authorization: Bearer {token}`

**Body (JSON):**
```json
{
  "users_id": 4,
  "name": "Lote A — Matrizes (renomeado)"
}
```

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Lote atualizado com sucesso",
  "data": { "id": 7, "users_id": 4, "name": "Lote A — Matrizes (renomeado)", "active": 1 }
}
```

**Erros possíveis:**
- `400 bad_request` — `flockId` inválido, ou campo `name` ausente.
- `500 internal_server_error` — lote não encontrado ou nenhuma alteração realizada.

## Entidade: Ovelhas — Sheeps (`/Sheeps`)

Entidade principal do sistema: representa cada ovelha cadastrada, vinculada a um lote (`Flock`). Todas as rotas abaixo exigem autenticação (`type_id = 2`).

### Estrutura do recurso

| Campo        | Tipo                | Descrição                                            |
|--------------|---------------------|-------------------------------------------------------|
| `id`         | int                 | Identificador único da ovelha.                        |
| `flocks_id`  | int                 | ID do lote ao qual a ovelha pertence.                  |
| `mother_id`  | int \| null         | ID da ovelha mãe, se identificada.                     |
| `father_id`  | int \| null         | ID da ovelha pai, se identificado.                     |
| `number`     | int                 | Número/código de identificação da ovelha.              |
| `eartag`     | string \| null      | Cor ou identificação do brinco.                        |
| `sex`        | string \| null      | Sexo da ovelha.                                        |
| `pregnancy`  | boolean (0/1)       | Indica se a ovelha está prenha.                         |
| `birthdate`  | date \| null        | Data de nascimento.                                    |
| `breed`      | string \| null      | Raça da ovelha.                                         |
| `active`     | boolean (0/1)       | Soft delete — `0` indica registro inativo/removido.     |

### Cadastrar ovelha
`POST /Sheeps`

**Headers:** `Authorization: Bearer {token}`

**Body (JSON):**
```json
{
  "flocks_id": 7,
  "number": 125
}
```

**Resposta 201:**
```json
{
  "code": 201,
  "type": "success",
  "status": "success",
  "message": "Lote inserido com sucesso",
  "data": {
    "id": 31,
    "flocks_id": 7,
    "number": 125,
    "active": 1
  }
}
```

**Erros possíveis:**
- `400 bad_request` — campo `number` ausente ou não numérico.
- `401 unauthorized` — token ausente/inválido.
- `500 internal_server_error` — falha ao inserir no banco.

> Observação: campos opcionais do modelo (`mother_id`, `father_id`, `eartag`, `sex`, `pregnancy`, `breed`) já são suportados pela camada de modelo (`Sheep`), mas ainda não são recebidos pelo `insert()` do controller — podem ser adicionados ao payload futuramente sem alterar a estrutura do banco.

### Listar todas as ovelhas
`GET /Sheeps`

**Headers:** `Authorization: Bearer {token}`

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Lista de lotes",
  "data": [
    { "id": 31, "flocks_id": 7, "number": 125, "active": 1 },
    { "id": 32, "flocks_id": 7, "number": 126, "active": 1 }
  ]
}
```

### Buscar ovelha por ID
`GET /Sheeps/{sheepId}`

**Headers:** `Authorization: Bearer {token}`

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Ovelha encontrada",
  "data": { "id": 31, "flocks_id": 7, "number": 125, "active": 1 }
}
```

**Erros possíveis:**
- `400 bad_request` — `sheepId` ausente ou não numérico.
- `404 not_found` — nenhuma ovelha com o ID informado.

### Atualizar ovelha
`PUT /Sheeps/{sheepId}`

**Headers:** `Authorization: Bearer {token}`

**Body (JSON):**
```json
{
  "flocks_id": 7,
  "number": 125
}
```

**Resposta 200:**
```json
{
  "code": 200,
  "type": "success",
  "status": "success",
  "message": "Lote atualizado com sucesso",
  "data": { "id": 31, "flocks_id": 7, "number": 125, "active": 1 }
}
```

**Erros possíveis:**
- `400 bad_request` — campo `number` ausente ou não numérico.
- `500 internal_server_error` — ovelha não encontrada ou nenhuma alteração realizada.


## Códigos de status HTTP utilizados

| Código | Status               | Quando ocorre                                                        |
|--------|-----------------------|-----------------------------------------------------------------------|
| 200    | `success`              | Operação de leitura ou atualização concluída com sucesso.             |
| 201    | `success` / `created`  | Recurso criado com sucesso.                                           |
| 400    | `bad_request`          | Parâmetros obrigatórios ausentes, inválidos ou malformados.           |
| 401    | `unauthorized`         | Token ausente, inválido, expirado, ou usuário sem permissão (`type_id` incorreto). Também usado para falha de login (e-mail/senha incorretos). |
| 404    | `not_found`            | Registro não encontrado pelo ID informado, ou rota inexistente.       |
| 500    | `internal_server_error`| Falha ao executar a operação no banco de dados.                        |

## Como rodar localmente

1. Clone o repositório e instale as dependências PHP via Composer:
   ```
   cd OviSystem/api
   composer install
   ```
2. Crie o banco de dados executando o script `data-base/db_ovisystem_script.sql` em um servidor MySQL local.
3. Configure as credenciais de conexão e a chave JWT em `api/source/Config/Config.php`.
4. Aponte o servidor (Apache/Nginx ou `php -S`) para a pasta `OviSystem`, de forma que a API fique acessível em `http://localhost/OviSystem/api`.
5. Use o Postman (ou ferramenta similar) para testar as rotas, lembrando de enviar o header `Authorization: Bearer {token}` nas rotas autenticadas após o login.
