<?php
declare(strict_types=1);

namespace ExceptionComponent;

use JsonSerializable;
use Throwable;

interface ExceptionInterface extends Throwable, JsonSerializable
{
    public function setCode(string $code): ExceptionInterface;

    public function setPrevious(Throwable $previous): ExceptionInterface;

    public function jsonSerialize(): string;

    public function addMessage(string $message): ExceptionInterface;
}
