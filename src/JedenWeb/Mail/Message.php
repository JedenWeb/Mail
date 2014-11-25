<?php

namespace JedenWeb\Mail;

use Bazo\TemplateFactory\TemplateFactory;
use JedenWeb;
use Nette;
use Nette\Mail\IMailer;
use Nette\Application\UI\ITemplate;

/**
 * @property-read \Nette\Mail\Message $message
 * @property-read \Nette\Application\UI\ITemplate $template
 * @author Pavel Jurásek
 */
class Message extends Nette\Object
{

	/** @var Nette\Mail\Message */
	private $message;	
	
	/** @var IMailer */
	private $mailer;

    /** @var TemplateFactory */
    private $templateFactory;
	
	/** @var ITemplate */
	private $template;

	/** @var string */
	private $templateDir;
	

	public function __construct($templateDir, IMailer $mailer, TemplateFactory $templateFactory)
	{
		$this->mailer = $mailer;
		$this->templateDir = $templateDir;
		$this->templateFactory = $templateFactory;
		
		$message = new Nette\Mail\Message;
		$message->setHeader('X-Mailer', NULL); // remove Nette Framework from header X-Mailer
		
		$this->message = $message;
	}

	
	/**
	 * Send message
	 */
	public function send()
	{
		if ($this->template instanceof ITemplate) {
			$this->message->setHtmlBody($this->template);
		}
		$this->mailer->send($this->message);
	}

	
	/**
	 * @return Nette\Mail\Message
	 */
	public function getMessage()
	{
		return $this->message;
	}
	

	/********************* templating *********************/
	

	/**
	 * @param string
     *
	 * @return JedenWeb\Mail\Message  Provides fluent interface.
	 * @throws Nette\InvalidArgumentException
	 */
	public function setTemplateFile($file)
	{
		if (!\Nette\Utils\Strings::endsWith($file, '.latte')) {
			$file .= '.latte';
		}
		
		if (strpos($file, DIRECTORY_SEPARATOR) === FALSE) {
			$file = $this->templateDir . DIRECTORY_SEPARATOR . $file;
		}
		$this->getTemplate()->setFile($file);
		
		return $this;
	}

	
	/**
	 * @param ITemplate
     *
	 * @return JedenWeb\Mail\Message  Provides fluent interface.
	 */
	public function setTemplate(ITemplate $template)
	{
		$this->template = $template;
		return $this;
	}
	

	/**
	 * @return ITemplate
	 */
	public function getTemplate()
	{
		if (!$this->template) {
			$this->setTemplate($this->templateFactory->createTemplate(NULL));
		}

		return $this->template;
	}

}
