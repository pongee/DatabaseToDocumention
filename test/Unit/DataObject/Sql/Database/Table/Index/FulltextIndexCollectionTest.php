<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndexCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;

class FulltextIndexCollectionTest extends TestCase
{
    public function getFulltextIndexsProvider(): array
    {
        return [
            [
                new FulltextIndex('id', ['idx_id']),
            ],
            [
                new FulltextIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new FulltextIndex('id', ['idx_id']),
                new FulltextIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $fulltextIndexCollection = new FulltextIndexCollection();

        $this->assertInstanceOf(FulltextIndexCollectionInterface::class, $fulltextIndexCollection);
    }

    /**
     * @dataProvider getFulltextIndexsProvider
     */
    public function testKeys(FulltextIndexInterface ...$fulltextIndexs): void
    {
        $fulltextIndexCollection = new FulltextIndexCollection();

        foreach ($fulltextIndexs as $fulltextIndex) {
            $fulltextIndexCollection->add($fulltextIndex);
        }

        foreach ($fulltextIndexCollection as $i => $fulltextIndex) {
            $this->assertInstanceOf(FulltextIndexInterface::class, $fulltextIndex);
        }

        $this->assertNull($fulltextIndexCollection->next());
        $this->assertNull($fulltextIndexCollection->key());
        $this->assertNull($fulltextIndexCollection->current());
        $this->assertFalse($fulltextIndexCollection->valid());

        $this->assertEquals(count($fulltextIndexs), $i + 1);
    }
}
