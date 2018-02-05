<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Export;

use Pongee\DatabaseToDocumention\DataObject\Sql\SchemaInterface;

interface ExportInterface
{
    public function export(SchemaInterface $schema): string;
}
