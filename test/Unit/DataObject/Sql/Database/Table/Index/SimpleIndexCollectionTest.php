<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndexInterface;

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
    public function testCollection(SimpleIndexInterface ...$simpleIndexs): void
    {
        $sut = new SimpleIndexCollection();

        foreach ($simpleIndexs as $simpleIndex) {
            $sut->add($simpleIndex);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(SimpleIndex::class, $item);
        }

        $this->assertCount(count($simpleIndexs), $sut->getIterator());
    }
}
