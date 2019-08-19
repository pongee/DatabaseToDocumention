<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;

class TableCollectionTest extends TestCase
{
    public function getTablesProvider(): array
    {
        return [
            [
                (new Table())->setName('member'),
            ],
            [
                (new Table())->setName('account'),
            ],
            [
                (new Table())->setName('member'),
                (new Table())->setName('account'),
                (new Table())->setName('log'),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $tableCollection = new TableCollection();

        $this->assertInstanceOf(TableCollectionInterface::class, $tableCollection);
    }

    /**
     * @dataProvider getTablesProvider
     */
    public function testTables(TableInterface ...$tables): void
    {
        $tableCollection = new TableCollection();

        $tableNames = [];
        foreach ($tables as $table) {
            $tableNames[] = $table->getName();

            $tableCollection->add($table);

            $this->assertEquals($table, $tableCollection->offsetGet($table->getName()));
        }

        foreach ($tableCollection as $tableName => $table) {
            $this->assertEquals($tableName, $table->getName());
            $this->assertTrue(in_array($table->getName(), $tableNames));

            $tableCollection->remove($table);
        }


        $this->assertTrue(is_array($tableCollection->toArray()));
    }
}
