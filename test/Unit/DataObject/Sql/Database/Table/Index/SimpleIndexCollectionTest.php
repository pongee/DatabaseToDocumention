<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndexCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;

class SimpleIndexCollectionTest extends TestCase
{
    public function getSimpleIndexsProvider(): array
    {
        return [
            [
                new SimpleIndex('id', ['idx_id']),
            ],
            [
                new SimpleIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
            [
                new SimpleIndex('id', ['idx_id']),
                new SimpleIndex('member_id', ['idx_member_id'], 'USING BTREE'),
            ],
        ];
    }

    /**
     * @dataProvider getSimpleIndexsProvider
     */
    public function testKeys(SimpleIndexInterface ...$simpleIndexs): void
    {
        $simpleIndexCollection = new SimpleIndexCollection();

        foreach ($simpleIndexs as $simpleIndex) {
            $simpleIndexCollection->add($simpleIndex);
        }

        foreach ($simpleIndexCollection as $i => $simpleIndex) {
            $this->assertInstanceOf(SimpleIndexInterface::class, $simpleIndex);
        }

        $this->assertNull($simpleIndexCollection->next());
        $this->assertNull($simpleIndexCollection->key());
        $this->assertNull($simpleIndexCollection->current());
        $this->assertFalse($simpleIndexCollection->valid());

        $this->assertEquals(count($simpleIndexs), $i + 1);
    }
}
