<?php

namespace CriminalOccurence\modules\generic\domain\exceptions;

class AccountNotFound
{
    public function __toString()
    {
        return "Conta não existe, por favor tente outras informações!";
    }
}
