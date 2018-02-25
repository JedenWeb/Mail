<?php declare(strict_types=1);

namespace JedenWeb\Mail\DI;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek
 */
class MailExtension extends Nette\DI\CompilerExtension
{

	/** @var array */
	private $defaults = [
		'templateDir' => '%appDir%/email',
	];

	public function loadConfiguration()
	{
        $config = $this->getConfig($this->defaults);
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('factory'))
			->setClass('JedenWeb\Mail\Message', array($config['templateDir']))
            ->setImplement('JedenWeb\Mail\IMessageFactory');
	}

}
