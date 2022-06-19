<?php

namespace CriminalOccurence\modules\generic\commands;

use CriminalOccurence\modules\generic\domain\entities\User;
use CriminalOccurence\modules\generic\interfaces\IAccountRepository;
use CriminalOccurence\modules\generic\domain\entities\command\UserCommand;

class UpdateUserCommand
{
    public function __construct(
        private IAccountRepository $accountRepository
    ) {
    }

    public function execute(array $request, array $rememberData)
    {
        $user = User::execute(
            new UserCommand(
                $request["name"],
                $request["email"],
                $request["password"]
            ),
            $rememberData,
            $request["id"]
        );

        if ($user->errorValue()) {
            redirect("update-account");
        }

        $userData = $user->getValue();

        $account = $this->accountRepository->update(
            $userData
        );

        return $account;
    }
}
