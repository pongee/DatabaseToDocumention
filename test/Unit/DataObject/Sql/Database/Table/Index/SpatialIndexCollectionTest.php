<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexInterface;

class SpatialIndexCollectionTest extends TestCase
{
    public function getSpatialIndexsProvider(): array
    {
        return [
            [
                new SpatialIndex('id', ['idx_id']),
            ],
            [
                new SpatialIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new SpatialIndex('id', ['idx_id']),
                new SpatialIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $spatialIndexCollection = new SpatialIndexCollection();

        $this->assertInstanceOf(SpatialIndexCollectionInterface::class, $spatialIndexCollection);
    }

    /**
     * @dataProvider getSpatialIndexsProvider
     */
    public function testKeys(SpatialIndexInterface ...$spatialIndexs): void
    {
        $spatialIndexCollection = new SpatialIndexCollection();

        foreach ($spatialIndexs as $spatialIndex) {
            $spatialIndexCollection->add($spatialIndex);
        }

        foreach ($spatialIndexCollection as $i => $spatialIndex) {
            $this->assertInstanceOf(SpatialIndexInterface::class, $spatialIndex);
        }

        $this->assertNull($spatialIndexCollection->next());
        $this->assertNull($spatialIndexCollection->key());
        $this->assertNull($spatialIndexCollection->current());
        $this->assertFalse($spatialIndexCollection->valid());

        $this->assertEquals(count($spatialIndexs), $i + 1);
    }
}
