<?php

function sayGoodBye(string $name)
{
    return "Hello {$name}, good bye!";
}

function route(string $route)
{
    return $_ENV["URL_BASE"] . $route;
}

function formHandler()
{
    if (!isset($_SESSION["formData"])) {
        return $_SESSION["formData"] = null;
    }

    return $_SESSION["formData"];
}

function redirect(string $route)
{
    header("Location: " . $_ENV["URL_BASE"] . $route);

    exit;
}

function status()
{
    return $_SESSION["result"];
}
