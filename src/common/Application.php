<?php

namespace CriminalOccurence\common;

/**
 * Application.
 *
 * Create a alias for dynamic access
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

use Exception;

class Application extends Exception
{
    /**
     *
     * Folder alias
     *
     * @var string $alias
     * @var string $path
     */
    protected static $alias = [];

    /**
     * @var array|null
     */
    protected static $config;

    public static function setAlias(string $alias, string $path)
    {
        self::$alias[$alias] = $path;
    }

    /**
     * Returns path
     *
     * @param string $alias
     * @return string
     * @throws Exception
     */
    public static function getAlias(string $alias)
    {
        if (!isset(self::$alias[$alias])) {
            throw new Exception("Path to \"$alias\" not found.", 500);
        }

        return self::$alias[$alias];
    }
}
