<?php
declare(strict_types=1);

namespace Neighborhoods\ExceptionComponent;

use Exception as PHPException;
use Throwable;

class Exception extends PHPException implements ExceptionInterface
{
    private $message = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function setPrevious(Throwable $previous): ExceptionInterface
    {
        $messages = $this->message;
        $code = $this->code;
        parent::__construct('', 0, $previous);
        $this->message = $messages;
        $this->code = $code;

        return $this;
    }

    public function setCode(string $code): ExceptionInterface
    {
        $this->code = $code;

        return $this;
    }

    private function getMessages(): array
    {
        return $this->message;
    }

    public function addMessage(string $message): ExceptionInterface
    {
        $this->message[] = $message;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
