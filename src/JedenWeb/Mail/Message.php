<?php

namespace JedenWeb\Mail;

use JedenWeb;
use Nette;
use Nette\Mail\IMailer;
use Nette\Application\Application;

/**
 * @property-read \Nette\Mail\Message $message
 * @property-read \Nette\Templating\FileTemplate $template
 * @author Pavel Jurásek <jurasekpavel@ctyrimedia.cz>
 */
class Message extends Nette\Object
{

	/** @var Nette\Mail\Message */
	private $message;	
	
	/** @var IMailer */
	private $mailer;
	
	/** @var Nette\Templating\FileTemplate */
	private $template;

	/** @var string */
	private $templateDir;
	
	/** @var Application */
	private $application;	
	
	
	
	/**
	 * @param string $templateDir
	 * @param IMailer $mailer
	 * @param Application $application
	 */
	public function __construct($templateDir, IMailer $mailer, Application $application)
	{
		$this->mailer = $mailer;
		$this->templateDir = $templateDir;
		$this->application = $application;
		
		$message = new Nette\Mail\Message;
		$message->setHeader('X-Mailer', NULL); // remove Nette Framework from header X-Mailer
		
		$this->message = $message;
	}
	
	
	
	/**
	 * Send message
	 */
	public function send()
	{
		if ($this->template instanceof Nette\Templating\ITemplate) {
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
	 * @param string $file
	 * @return JedenWeb\Mail\Message
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
	 * @param Nette\Templating\ITemplate $template
	 * @return JedenWeb\Mail\Message  Provides fluent interface.
	 */
	public function setTemplate(Nette\Templating\ITemplate $template)
	{
		$this->template = $template;
		return $this;
	}
	
	
	
	/**
	 * @return Nette\Templating\FileTemplate
	 */
	public function getTemplate()
	{
		if (!$this->template) {
			$this->setTemplate($this->createTemplate());
		}
		return $this->template;
	}


	
	/**
	 * @return Nette\Templating\FileTemplate
	 */
	private function createTemplate()
	{
		$template = new Nette\Templating\FileTemplate;
		$template->registerHelperLoader('Nette\Templating\Helpers::loader');
		$template->registerFilter(new Nette\Latte\Engine);
		
		$presenter = $this->application->getPresenter();
		
		// default parameters
		$template->presenter = $template->_presenter = $presenter;
		$template->control = $template->_control = $presenter;
		$template->setCacheStorage($presenter->getContext()->getService('nette.templateCacheStorage'));
		$template->user = $presenter->getUser();
		$template->netteHttpResponse = $presenter->getContext()->getByType('Nette\Http\Response');
		$template->netteCacheStorage = $presenter->getContext()->getByType('Nette\Caching\IStorage');
		$template->baseUri = $template->baseUrl = rtrim($presenter->getContext()->getByType('Nette\Http\Request')->getUrl()->getBaseUrl(), '/');
		$template->basePath = preg_replace('#https?://[^/]+#A', '', $template->baseUrl);

		return $template;
	}
	
}
