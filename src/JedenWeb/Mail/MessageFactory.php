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
	
	/** @var \Nette\Application\IPresenter */
	private $presenter;
	
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
		$this->presenter = $application->getPresenter();
	}

	
	
    /**
     * @return \JedenWeb\Mail\Message
     */
    public function create()
	{
		$email = new Message($this->templateDir, $this->mailer);
		$email->setTemplate($this->createTemplate());
		
		return $email;
	}
	
	
	
	/**
	 * @return \Nette\Templating\FileTemplate
	 */
	private function createTemplate()
	{
		$template = new Nette\Templating\FileTemplate;
		$template->registerHelperLoader('Nette\Templating\Helpers::loader');
		$template->registerFilter(new Nette\Latte\Engine);

		// default parameters
		$template->presenter = $template->_presenter = $this->presenter;
		$template->control = $template->_control = $this->presenter;
		$template->setCacheStorage($this->presenter->getContext()->getService('nette.templateCacheStorage'));
		$template->user = $this->presenter->getUser();
		$template->netteHttpResponse = $this->presenter->getContext()->getByType('Nette\Http\Response');
		$template->netteCacheStorage = $this->presenter->getContext()->getByType('Nette\Caching\IStorage');
		$template->baseUri = $template->baseUrl = rtrim($this->presenter->getContext()->getByType('Nette\Http\Request')->getUrl()->getBaseUrl(), '/');
		$template->basePath = preg_replace('#https?://[^/]+#A', '', $template->baseUrl);

		return $template;
	}	

}
