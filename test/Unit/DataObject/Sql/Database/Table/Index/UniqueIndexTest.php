<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

class UniqueIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $uniqueIndex = new UniqueIndex('idx_id', ['id']);

        $this->assertInstanceOf(UniqueIndexInterface::class, $uniqueIndex);
    }

    /**
     * @dataProvider getIndexProvider
     */
    public function testIndex(string $name, array $columns, string $otherParameters = ''): void
    {
        $uniqueIndex = new UniqueIndex($name, $columns, $otherParameters);

        $this->assertInstanceOf(UniqueIndexInterface::class, $uniqueIndex);

        $this->assertEquals($name, $uniqueIndex->getName());
        $this->assertEquals($columns, $uniqueIndex->getColumns());
        $this->assertEquals($otherParameters, $uniqueIndex->getOtherParameters());
    }
}
