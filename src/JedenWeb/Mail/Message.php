<?php declare(strict_types=1);

namespace JedenWeb\Mail;

use JedenWeb;
use Nette;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplateFactory;
use Nette\Mail\IMailer;
use Nette\Application\UI\ITemplate;

/**
 * @author Pavel Jurásek
 */
class Message
{

	/** @var Nette\Mail\Message */
	private $message;

	/** @var IMailer */
	private $mailer;

    /** @var ITemplateFactory */
    private $templateFactory;

	/** @var ITemplate */
	private $template;

	/** @var string */
	private $templateDir;

	/** @var LinkGenerator */
	private $linkGenerator;

	public function __construct($templateDir, IMailer $mailer, ITemplateFactory $templateFactory, LinkGenerator $linkGenerator)
	{
		$this->mailer = $mailer;
		$this->templateDir = $templateDir;
		$this->templateFactory = $templateFactory;

		$this->linkGenerator = $linkGenerator;
		$message = new Nette\Mail\Message;
		$message->setHeader('X-Mailer', null); // remove Nette Framework from header X-Mailer

		$this->message = $message;
	}

	public function send(): void
	{
		if ($this->template instanceof ITemplate) {
			$this->message->setHtmlBody((string) $this->template);
		}
		$this->mailer->send($this->message);
	}

	public function getMessage(): Nette\Mail\Message
	{
		return $this->message;
	}

	public function setTemplateFile(string $file): self
	{
		if (!\Nette\Utils\Strings::endsWith($file, '.latte')) {
			$file .= '.latte';
		}

		if (strpos($file, DIRECTORY_SEPARATOR) === false) {
			$file = $this->templateDir . DIRECTORY_SEPARATOR . $file;
		}
		$this->getTemplate()->setFile($file);

		return $this;
	}

	public function setTemplate(ITemplate $template): self
	{
		$this->template = $template;
		return $this;
	}

	public function getTemplate(): ITemplate
	{
		if (!$this->template) {
			$this->setTemplate($this->templateFactory->createTemplate(null));
			$this->template->getLatte()->addProvider('uiControl', $this->linkGenerator);
		}

		return $this->template;
	}

}
