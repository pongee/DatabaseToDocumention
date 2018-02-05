<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;

interface ColumnInterface
{
    public function __construct(string $name, string $type, array $typeParameters, string $otherParameters);

    public function getName(): string;

    public function getType(): string;

    public function getTypeParameters(): array;

    public function getOtherParameters(): string;
}
