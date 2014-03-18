<?php

namespace CL\ComposerInit;

use CL\ComposerInit\Prompt;
use CL\ComposerInit\TemplateHelper;
use Symfony\Component\Console\Output\OutputInterface;

class Template
{
    public static function getTemplateValues(OutputInterface $output, TemplateHelper $template)
    {
        return $template->retrieveParams($output, [
            new Prompt\Title(),
            new Prompt\Description(),
            new Prompt\PHPNamespace(),
            new Prompt\AuthorName(),
            new Prompt\AuhtorEmail(),
            new Prompt\Copyright(),
        ]);
    }
}
