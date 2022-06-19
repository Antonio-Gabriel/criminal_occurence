<?php

use CriminalOccurence\common\File;

function imageLinks(string $dirname)
{
    $file = new File("", "images/");
    return $file->getImages($dirname);
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
