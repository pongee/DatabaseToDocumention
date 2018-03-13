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
            ['member_id', 'INT', [10], 'UNSIGNED NOT NULL AUTO_INCREMENT', 'The member id'],
            ['type', 'VARCHAR', [64], 'NOT NULL', 'The type'],
            ['status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL', 'The status'],
        ];
    }

    /**
     * @dataProvider getColumnsProvider
     */
    public function testColumn(
        string $name,
        string $type,
        array $typeParameters,
        string $otherParameters,
        string $comment
    ): void {
        $column = new Column($name, $type, $typeParameters, $otherParameters, $comment);

        $this->assertInstanceOf(ColumnInterface::class, $column);

        $this->assertEquals($name, $column->getName());
        $this->assertEquals($type, $column->getType());
        $this->assertEquals($typeParameters, $column->getTypeParameters());
        $this->assertEquals($otherParameters, $column->getOtherParameters());
        $this->assertEquals($comment, $column->getComment());
    }
}
