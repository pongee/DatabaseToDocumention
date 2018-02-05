<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table\Index;

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;

class SpatialIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $spatialIndex = new SpatialIndex('idx_id', ['id']);

        $this->assertInstanceOf(SpatialIndexInterface::class, $spatialIndex);
    }

    /**
     * @dataProvider getIndexProvider
     */
    public function testData(string $name, array $columns, string $otherParameters = ''): void
    {
        $spatialIndex = new SpatialIndex($name, $columns, $otherParameters);

        $this->assertEquals($name, $spatialIndex->getName());
        $this->assertEquals($columns, $spatialIndex->getColumns());
        $this->assertEquals($otherParameters, $spatialIndex->getOtherParameters());
    }
}
