<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

class UniqueIndexCollectionTest extends TestCase
{
    public function getUniqueIndexsProvider(): array
    {
        return [
            [
                new UniqueIndex('id', ['idx_id']),
            ],
            [
                new UniqueIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new UniqueIndex('id', ['idx_id']),
                new UniqueIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    /**
     * @dataProvider getUniqueIndexsProvider
     */
    public function testCollection(UniqueIndexInterface ...$uniqueIndexs): void
    {
        $sut = new UniqueIndexCollection();

        foreach ($uniqueIndexs as $uniqueIndex) {
            $sut->add($uniqueIndex);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(UniqueIndex::class, $item);
        }

        $this->assertCount(count($uniqueIndexs), $sut->getIterator());
    }
}
