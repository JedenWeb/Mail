<?php

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../../src/JedenWeb/Mail/IMessageFactory.php';

class Implementation implements \JedenWeb\Mail\IMessageFactory
{

	public function create()
	{
		$mailer = Mockery::mock('Nette\Mail\IMailer');
		$templateFactory = Mockery::mock('Nette\Application\UI\ITemplateFactory');
		$linkGenerator = Mockery::mock('Nette\Application\LinkGenerator');

		return new \JedenWeb\Mail\Message('', $mailer, $templateFactory, $linkGenerator);
	}

}

$factory = new Implementation;

\Tester\Assert::type('JedenWeb\Mail\IMessageFactory', $factory);

\Tester\Assert::type('JedenWeb\Mail\Message', $factory->create());
