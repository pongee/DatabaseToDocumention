<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table\Index;

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;

class SimpleIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $simpleIndex = new SimpleIndex('idx_id', ['id']);

        $this->assertInstanceOf(SimpleIndexInterface::class, $simpleIndex);
    }

    /**
     * @dataProvider getIndexProvider
     */
    public function testData(string $name, array $columns, string $otherParameters = ''): void
    {
        $simpleIndex = new SimpleIndex($name, $columns, $otherParameters);

        $this->assertEquals($name, $simpleIndex->getName());
        $this->assertEquals($columns, $simpleIndex->getColumns());
        $this->assertEquals($otherParameters, $simpleIndex->getOtherParameters());
    }
}
