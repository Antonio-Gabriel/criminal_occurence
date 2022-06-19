<?php

namespace CriminalOccurence\modules\generic\interfaces;

use CriminalOccurence\modules\generic\domain\entities\User;

interface IAccountRepository
{
    public function create(User $user);
    public function update(User $user);

    public function get();
    public function findByEmail(string $email);
}
