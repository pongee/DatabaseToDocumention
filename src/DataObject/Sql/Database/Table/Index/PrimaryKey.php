<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index;

class PrimaryKey extends IndexAbstract implements PrimaryKeyInterface
{
    public function __construct(array $columns, string $otherParameters = '')
    {
        $this->columns = $columns;
        $this->otherParameters = $otherParameters;
    }
}
