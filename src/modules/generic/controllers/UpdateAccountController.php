<?php

namespace CriminalOccurence\modules\generic\controllers;

use CriminalOccurence\middleware\log\Logger;
use CriminalOccurence\utils\RemenberEnteredData;
use CriminalOccurence\modules\generic\commands\UpdateUserCommand;
use CriminalOccurence\modules\generic\controllers\contract\IHandle;
use CriminalOccurence\modules\generic\repositories\AccountRepository;

use CriminalOccurence\modules\generic\queries\GetUserByEmailQuery;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateAccountController implements IHandle
{
    use RemenberEnteredData;

    public function handle(Request $request, Response $response)
    {
        $requestData = self::register($request->getParsedBody());

        $userCommand = new UpdateUserCommand(new AccountRepository());
        $result = $userCommand->execute($request->getParsedBody(), $requestData);
        var_dump($result);

        if ($result) {

            $getUserByEmailQuery = new GetUserByEmailQuery(new AccountRepository());
            $data = $getUserByEmailQuery->execute($requestData["email"]);

            unset($_SESSION['user']);

            $_SESSION['user'] = $data[0];

            $_SESSION["result"] = [
                "status" => 200,
                "msg" => "Dados atualizados com sucesso"
            ];

            Logger::logger("Dados actualizados com sucesso", "info", $requestData);

            unset($_SESSION["formData"]);
            redirect("home");
        }

        $_SESSION["result"] = [
            "status" => 403,
            "msg" => "Erro na atualização dos dados"
        ];

        Logger::logger("Erro na actualização dos dados", "error", $requestData);

        unset($_SESSION["formData"]);
        redirect("update-account");
    }
}
