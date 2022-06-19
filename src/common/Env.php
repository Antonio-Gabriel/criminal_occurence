<?php

namespace CriminalOccurence\common;

/**
 * Env.
 *
 * Enviroments configurations.
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

use Dotenv\Dotenv;
use CriminalOccurence\common\Application;

abstract class Env
{
    public static function init()
    {
        $dotEnv = Dotenv::createImmutable(
            Application::getAlias("@root")
        );
        $dotEnv->load();
    }
}
