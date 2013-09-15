<?php

namespace JedenWeb\Mail;

use Nette;
use Nette\Mail\IMailer;
use Nette\Application\IPresenter;

/**
 * @property-read \Nette\Mail\Message $message
 * @property-read Nette\Templating\FileTemplate $template
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class Message extends Nette\Object
{

	/** @var \Nette\Mail\Message */
	private $message;	
	
	/** @var \Nette\Mail\IMailer */
	private $mailer;
	
	/** @var \Nette\Templating\FileTemplate */
	private $template;

	/** @var string */
	private $templateDir;	
	
	
	
	/**
	 * @param string $templateDir
	 * @param \Nette\Mail\IMailer $mailer
	 */
	public function __construct($templateDir, IMailer $mailer)
	{		
		$this->templateDir = $templateDir;
		$this->mailer = $mailer;
		
		$message = new Nette\Mail\Message;
		$message->setHeader('X-Mailer', NULL); // remove Nette Framework from header X-Mailer
		
		$this->message = $message;
	}
	
	
	
	/**
	 * Send message
	 */
	public function send()
	{
		$this->message->setHtmlBody($this->template);
		$this->mailer->send($this->message);
	}
	
	
	
	/**
	 * @return \Nette\Mail\Message
	 */
	public function getMessage()
	{
		return $this->message;
	}	
	
	
	
	/********************* templating *********************/
	
	
	
	/**
	 * @param string $file
	 * @return \JedenWeb\Mail\Message
	 * @throws \Nette\InvalidArgumentException
	 */
	public function setTemplateFile($file)
	{
		if (!\Nette\Utils\Strings::endsWith($file, '.latte')) {
			$file .= '.latte';
		}
		
		$file = strpos($file, DIRECTORY_SEPARATOR) === FALSE ? $this->templateDir.DIRECTORY_SEPARATOR.$file : $file;
		$this->template->setFile($file);
		
		return $this;
	}
	
	
	
	/**
	 * @param \Nette\Templating\ITemplate $template
	 * @return \JedenWeb\Mail\Message  Provides fluent interface.
	 */
	public function setTemplate(Nette\Templating\ITemplate $template)
	{
		$this->template = $template;
		return $this;
	}
	
	
	
	/**
	 * @return \Nette\Templating\FileTemplate
	 */
	public function getTemplate()
	{
		return $this->template;
	}
	
}
