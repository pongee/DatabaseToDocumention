<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Export;

use Pongee\DatabaseToDocumentation\DataObject\Sql\SchemaInterface;

interface ExportInterface
{
    public function export(SchemaInterface $schema): string;
}
