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
        $message = $this->message;
        $code = $this->code;
        parent::__construct('', 0, $previous);
        $this->message = $message;
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
        return $this->messages;
    }

    public function addMessage(string $message): ExceptionInterface
    {
        if ($this->message === '') {
            $messages = [];
        } else {
            /** @noinspection JsonEncodingApiUsageInspection */
            $messages = json_decode($this->message, true);
        }

        $messages[] = $message;
        /** @noinspection JsonEncodingApiUsageInspection */
        $this->message = json_encode($messages);

        return $this;
    }

    public function jsonSerialize(): string
    {
        /** @noinspection JsonEncodingApiUsageInspection */
        return json_decode($this->getMessage(), true);
    }
}
