<?php

namespace App\Http\Controllers;

use Twig_Environment;

class AbstractController
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function renderTemplate(string $template, array $variables = []): string
    {
        return $this->twig->render($template, $variables);
    }
}