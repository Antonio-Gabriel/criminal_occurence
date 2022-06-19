<?php

namespace CriminalOccurence\modules\generic\validators;

class Name
{
    public static function isValid(string $name)
    {
        /**
         * Examples :
         * Marcia J. Gaieta
         * Adrian'n Petter
         */
        return (!preg_match(
            "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i",
            $name
        )) ? false : true;
    }
}
