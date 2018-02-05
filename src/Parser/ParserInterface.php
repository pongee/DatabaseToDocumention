<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Parser;

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\SchemaInterface;

interface ParserInterface
{
    public function run(string $sqls, ConnectionCollectionInterface $forcedConnectionCollection): SchemaInterface;
}
