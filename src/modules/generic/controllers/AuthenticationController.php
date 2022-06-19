<?php

namespace CriminalOccurence\modules\generic\controllers;

use CriminalOccurence\modules\generic\controllers\contract\IHandle;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use CriminalOccurence\middleware\log\Logger;
use CriminalOccurence\utils\RemenberEnteredData;
use CriminalOccurence\modules\generic\validators\Email;

use CriminalOccurence\modules\generic\repositories\AccountRepository;
use  CriminalOccurence\modules\generic\commands\AuthenticationCommand;
use CriminalOccurence\modules\generic\domain\entities\command\UserCommand;

class AuthenticationController implements IHandle
{
    use RemenberEnteredData;

    public function handle(Request $request, Response $response)
    {
        $requestData = self::register($request->getParsedBody());

        $userCommand = new UserCommand("", "", "");

        if (($error =  $userCommand->isRequiredFields([
            "email" => $requestData["email"],
            "password" => $requestData["password"]
        ])->errorValue())) {

            self::registerAnError($error, $requestData);

            redirect('');
        }

        if (!Email::isValid($requestData["email"])) {

            self::registerAnError([
                "email" => "Email informádo é inválido!"
            ], $requestData);

            redirect('');
        }

        $authCommand = new AuthenticationCommand(new AccountRepository());
        $result = $authCommand->execute($requestData['email'], $requestData['password']);

            if (gettype($result) == "object") {

                $_SESSION["result"] = [
                    "status" => 404,
                    "msg" => "Conta não existe!"
                ];

                Logger::logger("Conta não existe", "error", $requestData);

                unset($_SESSION['formData']);

                redirect('');
            }

            if ($result == 0) {

                $_SESSION["result"] = [
                    "status" => 401,
                    "msg" => "Usuário ou senha inválida!"
                ];

                Logger::logger("Usuário ou senha inválida", "error", $requestData);

                unset($_SESSION['formData']);

                redirect('');
            }

            unset($_SESSION['formData']);

            redirect('home');
    }
}
