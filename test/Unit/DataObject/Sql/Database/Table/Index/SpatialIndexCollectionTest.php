<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndexCollection;
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
    /**
     * @dataProvider getSpatialIndexsProvider
     */
    public function testCollection(SpatialIndexInterface ...$spatialIndexs): void
    {
        $sut = new SpatialIndexCollection();

        foreach ($spatialIndexs as $spatialIndex) {
            $sut->add($spatialIndex);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(SpatialIndex::class, $item);
        }

        $this->assertCount(count($spatialIndexs), $sut->getIterator());
    }
}
