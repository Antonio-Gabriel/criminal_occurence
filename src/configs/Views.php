<?php

namespace CriminalOccurence\configs;

/**
 * Views.
 *
 * Template engine.
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;

use CriminalOccurence\common\Application;

class Views
{
    private string $path;
    private array $directories = [];

    public function __construct(
        private string $module,
        private ?array $permitedDirectories = null,
        private ?FilesystemLoader $loader = null,
        private ?Environment $twig = null
    ) {
        if (!is_null($permitedDirectories)) {
            array_push($this->directories, ...$permitedDirectories);
        }

        $this->path = Application::getAlias("@modules") . $module;

        $this->initTemplateEngineBase();
    }

    private function initTemplateEngineBase()
    {
        $this->loader = new FilesystemLoader($this->path);        

        if (!empty($this->directories)) {
            foreach ($this->directories as $dir) {
                $this->loader->addPath($this->path . $dir, $dir);
            }
        }

        $this->twig = new Environment($this->loader, [
            "debug" => true,
            "auto_reload" => true,
            "charset" => "utf-8"
        ]);

        $this->twig->addExtension(new DebugExtension);
        $this->twig->addFunction(new TwigFunction("route", "route"));
        $this->twig->addFunction(new TwigFunction("formData", "formHandler"));
        $this->twig->addFunction(new TwigFunction("imageLinks", "imageLinks"));
    }

    public function render(string $page, array $data = [])
    {
        echo $this->twig->render($page, $data);
    }

    public function display(string $page)
    {
        $this->twig->display($page);
    }
}
