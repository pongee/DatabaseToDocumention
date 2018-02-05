<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\ColumnInterface;

class ColumnTest extends TestCase
{
    public function getColumnsProvider(): array
    {
        return [
            ['member_id', 'INT', [10], 'UNSIGNED NOT NULL AUTO_INCREMENT'],
            ['type', 'VARCHAR', [64], 'NOT NULL'],
            ['status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL'],
        ];
    }

    /**
     * @dataProvider getColumnsProvider
     */
    public function testColumn(string $name, string $type, array $typeParameters, string $otherParameters = ''): void
    {
        $column = new Column($name, $type, $typeParameters, $otherParameters);

        $this->assertInstanceOf(ColumnInterface::class, $column);

        $this->assertEquals($name, $column->getName());
        $this->assertEquals($type, $column->getType());
        $this->assertEquals($typeParameters, $column->getTypeParameters());
        $this->assertEquals($otherParameters, $column->getOtherParameters());
    }
}
