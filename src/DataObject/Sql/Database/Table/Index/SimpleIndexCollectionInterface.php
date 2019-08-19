<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

interface SimpleIndexCollectionInterface extends \Iterator
{
    public function add(SimpleIndexInterface $key);

    public function rewind(): void;

    public function current(): ?SimpleIndexInterface;

    public function key(): ?int;

    public function next(): ?SimpleIndexInterface;

    public function valid(): bool;
}
