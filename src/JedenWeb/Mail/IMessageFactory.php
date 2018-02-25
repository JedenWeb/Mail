<?php declare(strict_types=1);

namespace JedenWeb\Mail;

/**
 * @author Pavel Jurásek
 */
interface IMessageFactory
{

    public function create(): Message;

}
