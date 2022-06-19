<?php

namespace CriminalOccurence\utils;

use CriminalOccurence\common\Application;

trait LinkGeneratorTrait
{
    public static function generateLink(string $dirname, string $file): string
    {

        return $_ENV["URL_BASE"] .
            Application::getAlias("@images") .
            $dirname . DIRECTORY_SEPARATOR . $file;
    }
}
