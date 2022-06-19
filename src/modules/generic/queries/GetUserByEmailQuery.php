<?php

namespace CriminalOccurence\modules\generic\queries;

use CriminalOccurence\modules\generic\interfaces\IAccountRepository;

class GetUserByEmailQuery
{
    public function __construct(
        private ?IAccountRepository $iAccountRepository
    ) {
    }

    public function execute(string $email)
    {
        return $this->iAccountRepository->findByEmail($email);
    }
}
