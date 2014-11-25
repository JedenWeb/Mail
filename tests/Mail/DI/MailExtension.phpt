<?php

use JedenWeb\Mail\DI\MailExtension;

require __DIR__ . '/../../bootstrap.php';

class ProcessingCompiler extends Nette\DI\Compiler
{
 	public function generateCode($className, $parentName = NULL)
    {
        return NULL;
    }
}

$compiler = new ProcessingCompiler;
$compiler->addExtension('mail', new MailExtension);

\Tester\Assert::null($compiler->compile(array(
    'parameters' => array(
        'appDir' => __DIR__,
    ),
), 'SystemContainer', 'Nette\DI\Container'));
