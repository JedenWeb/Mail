<?php

use JedenWeb\Mail\DI\MailExtension;

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/JedenWeb/Mail/IMessageFactory.php';

$configurator = new Nette\Configurator;
$configurator->addConfig(__DIR__ . '/config.neon');
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/../temp');

$container = $configurator->createContainer();

$factory = $container->getByType('JedenWeb\Mail\IMessageFactory');

\Tester\Assert::type('JedenWeb\Mail\IMessageFactory', $factory);
