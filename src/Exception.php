<?php
declare(strict_types=1);

namespace Neighborhoods\ExceptionComponent;

use Exception as PHPException;
use Throwable;

class Exception extends PHPException implements ExceptionInterface
{
    private $messages = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function setPrevious(Throwable $previous): ExceptionInterface
    {
        $messages = $this->messages;
        $code = $this->code;
        parent::__construct('', 0, $previous);
        $this->messages = $messages;
        $this->code = $code;

        return $this;
    }

    public function setCode(string $code): ExceptionInterface
    {
        $this->code = $code;

        return $this;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function addMessage(string $message): ExceptionInterface
    {
        $this->messages[] = $message;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
