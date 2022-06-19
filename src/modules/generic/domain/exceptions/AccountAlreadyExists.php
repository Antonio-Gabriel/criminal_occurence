<?php

namespace CriminalOccurence\modules\generic\domain\exceptions;

class AccountAlreadyExists
{
    public function __toString()
    {
        return "Já existe um usuário com este email, por favor tente um outro";
    }
}
