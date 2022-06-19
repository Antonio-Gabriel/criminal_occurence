<?php

namespace CriminalOccurence\modules\generic\commands;

use CriminalOccurence\middleware\security\Hash;

use CriminalOccurence\modules\generic\interfaces\IAccountRepository;
use CriminalOccurence\modules\generic\domain\exceptions\AccountNotFound;

class AuthenticationCommand
{
    public function __construct(
        private IAccountRepository $accountRepository
    ) {
    }

    public function execute(string $email, string $password)
    {
        $data = $this->accountRepository->findByEmail($email);

        if (!$data) {
            return new AccountNotFound;
        }

        if (!Hash::compare($password, $data[0]['password'])) {
            return 0;
        }

        $_SESSION['user'] = $data[0];

        return 1;
    }
}
