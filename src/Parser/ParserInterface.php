<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Parser;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\SchemaInterface;

interface ParserInterface
{
    public function run(string $sqls, ConnectionCollectionInterface $forcedConnectionCollection): SchemaInterface;
}
