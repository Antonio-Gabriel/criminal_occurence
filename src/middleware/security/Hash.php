<?php

namespace CriminalOccurence\middleware\security;

class Hash
{
    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function compare(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
