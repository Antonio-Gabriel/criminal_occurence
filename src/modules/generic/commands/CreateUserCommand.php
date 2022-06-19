<?php

namespace CriminalOccurence\modules\generic\commands;

use CriminalOccurence\common\File;

use CriminalOccurence\modules\generic\domain\entities\User;

use CriminalOccurence\modules\generic\interfaces\IAccountRepository;
use CriminalOccurence\modules\generic\domain\entities\command\UserCommand;
use CriminalOccurence\modules\generic\domain\exceptions\AccountAlreadyExists;

class CreateUserCommand
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
            $rememberData
        );

        if ($user->errorValue()) {
            redirect("create-account");
        }

        $userData = $user->getValue();

        $accountAlreadyExists = $this->accountRepository->findByEmail(
            $userData->props->email
        );

        if ($accountAlreadyExists) {
            return new AccountAlreadyExists;
        }

        $file = new File("photo", "images/");

        $userData->props->imageDir = $file->uploadImage();

        $account = $this->accountRepository->create(
            $userData
        );

        return $account;
    }
}
