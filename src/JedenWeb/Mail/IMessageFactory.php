<?php

namespace JedenWeb\Mail;

/**
 * @author Pavel Jurásek
 */
interface IMessageFactory
{

    /**
     * @return Message
     */
    public function create();

}
 