<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexCollection;

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

    /**
     * @dataProvider getFulltextIndexsProvider
     */
    public function testCollection(FulltextIndex ...$indexs): void
    {
        $sut = new FulltextIndexCollection();

        foreach ($indexs as $index) {
            $sut->add($index);
        }

        foreach ($sut as $item) {
            $this->assertInstanceOf(FulltextIndex::class, $item);
        }

        $this->assertCount(count($indexs), $sut->getIterator());
    }
}
