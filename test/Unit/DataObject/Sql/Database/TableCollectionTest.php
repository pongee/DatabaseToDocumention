<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableCollection;
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

    /**
     * @dataProvider getTablesProvider
     */
    public function testCollection(TableInterface ...$tables): void
    {
        $sut = new TableCollection();

        foreach ($tables as $table) {
            $sut->add($table);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(TableInterface::class, $item);
        }

        $this->assertCount(count($tables), $sut->getIterator());
    }
}
