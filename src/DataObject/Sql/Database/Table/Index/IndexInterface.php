<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

interface IndexInterface
{
    public function getColumns(): array;

    public function getOtherParameters(): string;
}
