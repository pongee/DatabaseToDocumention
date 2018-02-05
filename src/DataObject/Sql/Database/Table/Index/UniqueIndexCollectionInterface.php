<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index;

interface UniqueIndexCollectionInterface extends \Iterator
{
    public function add(UniqueIndexInterface $uniqueIndex);

    public function rewind(): void;

    public function current(): ?UniqueIndexInterface;

    public function key(): ?int;

    public function next(): ?UniqueIndexInterface;

    public function valid(): bool;
}
