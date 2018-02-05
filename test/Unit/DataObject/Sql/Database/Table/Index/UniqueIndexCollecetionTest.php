<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndexCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndexInterface;

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

    public function testInstanceOf(): void
    {
        $uniqueIndexCollection = new UniqueIndexCollection();

        $this->assertInstanceOf(UniqueIndexCollectionInterface::class, $uniqueIndexCollection);
    }

    /**
     * @dataProvider getUniqueIndexsProvider
     */
    public function testKeys(UniqueIndexInterface ...$uniqueIndexs): void
    {
        $uniqueIndexCollection = new UniqueIndexCollection();

        foreach ($uniqueIndexs as $uniqueIndex) {
            $uniqueIndexCollection->add($uniqueIndex);
        }

        foreach ($uniqueIndexCollection as $i => $uniqueIndex) {
            $this->assertInstanceOf(UniqueIndexInterface::class, $uniqueIndex);
        }

        $this->assertNull($uniqueIndexCollection->next());
        $this->assertNull($uniqueIndexCollection->key());
        $this->assertNull($uniqueIndexCollection->current());
        $this->assertFalse($uniqueIndexCollection->valid());

        $this->assertEquals(count($uniqueIndexs), $i + 1);
    }
}
