<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection;

interface ConnectionCollectionInterface extends \Iterator
{
    public function add(ConnectionInterface $connection);

    public function adds(ConnectionInterface ...$connections);

    public function rewind(): void;

    public function current(): ?ConnectionInterface;

    public function key(): ?int;

    public function next(): ?ConnectionInterface;

    public function valid(): bool;

    public function toArray(): array;
}
