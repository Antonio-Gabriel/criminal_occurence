<?php

namespace CriminalOccurence\middleware\log;

/**
 * Logger.
 *
 * manage the activities of app.
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

use Monolog\Logger as LoggerDependency;
use Monolog\Handler\StreamHandler;

use CriminalOccurence\common\Application;

class Logger
{
    private static function initLogBaseConfig()
    {
        $logger = new LoggerDependency("logger");
        $logger->pushHandler(new StreamHandler(
            Application::getAlias("@log") . "logs.log"
        ));

        return $logger;
    }

    /**
     * Register logs of applications for management the activities
     * 
     * @param message log messages, depending of log type
     * @param type log type / (info, debug, warning, error)
     * @param context data sending
     * 
     * @return null
     */
    public static function logger(string $message, string $type = "info", array $context = [])
    {
        $logger = self::initLogBaseConfig();

        match ($type) {
            "error" => $logger->error($message, $context),
            "warning" => $logger->warning($message, $context),
            "debug" => $logger->debug($message, $context),
            default => $logger->info($message, $context)
        };
    }
}
