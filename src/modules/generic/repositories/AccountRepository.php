<?php

namespace CriminalOccurence\modules\generic\repositories;

use CriminalOccurence\configs\Sql;
use CriminalOccurence\modules\generic\domain\entities\User;
use CriminalOccurence\modules\generic\interfaces\IAccountRepository;

class AccountRepository implements IAccountRepository
{

    public function __construct(
        private ?Sql $sql = null
    ) {
        $this->sql = new Sql();
    }

    public function create(User $user)
    {
        return $this->sql->query(
            "INSERT INTO test (id, name, email, password, image_dir) 
             VALUES (:id, :name, :email, :password, :image_dir)",
            [
                ":id" => $user->getId(),
                ":name" => $user->props->name,
                ":email" => $user->props->email,
                ":password" => $user->props->password,
                ":image_dir" => $user->props->imageDir
            ]
        );
    }

    public function update(User $user)
    {
        return $this->sql->query(
            "UPDATE test SET name = :name, email = :email, password = :password WHERE id = :id",
            [
                ":id" => $user->getId(),
                ":name"=> $user->props->name,
                ":email"=> $user->props->email,
                ":password" => $user->props->password,
            ]
        );
    }

    public function get()
    {
    }

    public function findByEmail(string $email)
    {
        return $this->sql->select("SELECT * FROM test WHERE email = :email",  [
            ":email" => $email
        ]);
    }
}
