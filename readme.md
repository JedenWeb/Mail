# Mail

Simple mail factory for [Nette Framework](http://nette.org/)

## Instalation

The best way to install jedenweb/mail is using  [Composer](http://getcomposer.org/):


```json
{
	"require": {
		"jedenweb/mail": "dev-master"
	}
}
```

After that you have to register extension in config.neon.

```neon
extensions:
	mail: JedenWeb\Mail\DI\MailExtension
```

## Usage

### Send mail

```php

	/**
	 * @inject
	 * @var JedenWeb\Mail\MessageFactory
	 */
	public $messageFactory;


	public function sendMail()
	{
		$email = $this->messageFactory->create();

		$email->message->addTo(...);
		$email->template->data = ...;

		$email->send();
	}

```
