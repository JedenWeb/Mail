<?php

namespace JedenWeb\Mail;

use Nette;
use Nette\Mail\IMailer;
use Nette\Application\Application;

/**
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class MessageFactory
{
	
	/** @var \Nette\Mail\IMailer */
	private $mailer;
	
	/** @var Application */
	private $application;	
	
	/** @var string */
	private $templateDir;
	
	
	
	/**
	 * @param string $templateDir
	 * @param \Nette\Mail\IMailer $mailer
	 * @param \Nette\Application\Application $application
	 */
	public function __construct($templateDir, IMailer $mailer, Application $application)
	{
		$this->templateDir = $templateDir;
		$this->mailer = $mailer;
		$this->application = $application;
	}

	
	
    /**
     * @return \JedenWeb\Mail\Message
     */
    public function create()
	{
		$email = new Message($this->templateDir, $this->mailer, $this->application);
		
		return $email;
	}

}
