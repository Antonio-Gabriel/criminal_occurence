<?php

namespace CriminalOccurence\modules\generic\controllers;

use CriminalOccurence\middleware\log\Logger;
use CriminalOccurence\utils\RemenberEnteredData;
use CriminalOccurence\modules\generic\controllers\contract\IHandle;
use CriminalOccurence\modules\generic\repositories\AccountRepository;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use CriminalOccurence\modules\generic\commands\CreateUserCommand;

class CreateAccountController implements IHandle
{
    use RemenberEnteredData;

    public function handle(Request $request, Response $response)
    {
        $requestData = self::register($request->getParsedBody());

        $userCommand = new CreateUserCommand(new AccountRepository());
        $result = $userCommand->execute($request->getParsedBody(), $requestData);

        if (gettype($result) == "object") {

            $_SESSION["result"] = [
                "status" => 404,
                "msg" => strval($result)
            ];

            Logger::logger($result, "error", $requestData);

            unset($_SESSION['formData']);

            redirect('create-account');
        }

        if ($result) {
            $_SESSION["result"] = [
                "status" => 200,
                "msg" => "Conta Criada com sucesso"
            ];

            Logger::logger("Conta Criada com sucesso", "info", $requestData);

            unset($_SESSION["formData"]);
            redirect("");
        }

        $_SESSION["result"] = [
            "status" => 403,
            "msg" => "Erro ao criar conta"
        ];

        Logger::logger("Erro ao criar conta", "error", $requestData);

        unset($_SESSION["formData"]);
        redirect("create-account");
    }
}
