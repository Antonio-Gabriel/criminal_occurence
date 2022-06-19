<?php

namespace CriminalOccurence\modules\generic\domain\entities;

use CriminalOccurence\common\Entity;
use CriminalOccurence\common\Result;

use CriminalOccurence\modules\generic\domain\entities\command\UserCommand;

use CriminalOccurence\middleware\security\Hash;
use CriminalOccurence\utils\RemenberEnteredData;

class User extends Entity
{
    use RemenberEnteredData;

    private function __construct(
        public $props,
        protected ?string $id = null
    ) {
        parent::__construct($props, $id);
    }

    public static function execute(UserCommand $props, ?array $requestData = null, ?string $id = null)
    {
        $validator = $props->validate();
        
        if ($validator->errorValue()) {
            self::registerAnError($validator->errorValue(), $requestData);
        
            return Result::Fail("Validation error");
        }
        
        $user = new User($props, $id);
        
        $user->props->password = Hash::encrypt(
            $user->props->password
        );

        return Result::Ok($user);
    }
}
