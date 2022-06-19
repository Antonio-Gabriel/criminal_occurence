<?php

namespace CriminalOccurence\middleware\security;

trait Authorization
{
    public static function notAuthorizated()
    {
        if (!isset($_SESSION['user'])) {
            redirect('');
        }
    }

    public static function isAuthorizated()
    {
        if (isset($_SESSION['user'])) {
            redirect('home');
        }
    }
}
