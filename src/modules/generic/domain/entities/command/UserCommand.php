<?php

namespace CriminalOccurence\modules\generic\domain\entities\command;

use CriminalOccurence\common\Result;

use CriminalOccurence\modules\generic\validators\{Email, Name};

class UserCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?int $imageDir = null
    ) {
    }

    public function validate()
    {
        if (($error = $this->isRequiredFields([
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password
        ])->errorValue())) {
            return Result::Fail($error);
        }

        if (!Email::isValid($this->email)) {
            return Result::Fail([
                "email" => "Email informádo é inválido!"
            ]);
        }

        if (Name::isValid($this->name)) {
            return Result::Fail([
                "name" => "Nome possue caracteres inválidos!"
            ]);
        }

        return Result::Ok(true);
    }

    public function isRequiredFields(array $fields)
    {
        foreach ($fields as $key => $value) {
            if (empty($value)) {
                return Result::Fail([
                    $key => "O campo {$key} é obrigatório"
                ]);
            }
        }

        return Result::Ok(true);
    }
}
