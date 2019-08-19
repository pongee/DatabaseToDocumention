<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

interface FulltextIndexCollectionInterface extends \Iterator
{
    public function add(FulltextIndexInterface $key);

    public function rewind(): void;

    public function current(): ?FulltextIndexInterface;

    public function key(): ?int;

    public function next(): ?FulltextIndexInterface;

    public function valid(): bool;
}
