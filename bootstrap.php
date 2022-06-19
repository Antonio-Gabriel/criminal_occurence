<?php

use CriminalOccurence\common\Env;
use CriminalOccurence\common\Application;

Application::setAlias("@root", __DIR__);
Application::setAlias(
    "@log",
    __DIR__ . DIRECTORY_SEPARATOR .
        "src" . DIRECTORY_SEPARATOR .
        "resources" . DIRECTORY_SEPARATOR .
        "log" . DIRECTORY_SEPARATOR
);

Application::setAlias(
    "@files",
    __DIR__ . DIRECTORY_SEPARATOR .
        "src" . DIRECTORY_SEPARATOR .
        "resources" . DIRECTORY_SEPARATOR .
        "files" . DIRECTORY_SEPARATOR
);

Application::setAlias(
    "@images",
    "src" . DIRECTORY_SEPARATOR .
        "resources" . DIRECTORY_SEPARATOR .
        "files" . DIRECTORY_SEPARATOR . "images"
        . DIRECTORY_SEPARATOR
);

Application::setAlias(
    "@modules",
    __DIR__ . DIRECTORY_SEPARATOR .
        "src" . DIRECTORY_SEPARATOR .
        "modules" . DIRECTORY_SEPARATOR
);

Application::setAlias("@src", __DIR__ . DIRECTORY_SEPARATOR . "src");

Env::init();
