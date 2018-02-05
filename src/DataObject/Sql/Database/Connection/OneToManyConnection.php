<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection;

class OneToManyConnection extends ConnectionAbstract
{
    public function getType(): string
    {
        return 'OneToMany';
    }
}
