<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;

class Column implements ColumnInterface
{
    /** @var string */
    private $name;
    /** @var string */
    private $type;
    /** @var array */
    private $typeParameters;
    /** @var string */
    private $otherParameters;

    public function __construct(string $name, string $type, array $typeParameters, string $otherParameters)
    {
        $this->name            = $name;
        $this->type            = $type;
        $this->typeParameters  = $typeParameters;
        $this->otherParameters = $otherParameters;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTypeParameters(): array
    {
        return $this->typeParameters;
    }

    public function getOtherParameters(): string
    {
        return $this->otherParameters;
    }
}
