<?php

namespace JedenWeb\Mail\DI;

use JedenWeb;
use Nette;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class MailExtension extends Nette\DI\CompilerExtension
{	
	
	/** @var array */
	private $defaults = array(
		'templateDir' => '%appDir%/email',
	);
	
	
	
	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$container = $this->getContainerBuilder();
		
		$container->addDefinition($this->prefix('factory'))
			->setClass('JedenWeb\Mail\MessageFactory', array($config['templateDir']));
	}

}
