<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndexInterface;

class FulltextIndexTest extends NamedIndexAbstract
{
    public function testInstanceOf(): void
    {
        $fulltextIndex = new FulltextIndex('idx_id', ['id']);

        $this->assertInstanceOf(FulltextIndexInterface::class, $fulltextIndex);
    }

    /**
     * @dataProvider getIndexProvider
     */
    public function testData(string $name, array $columns, $otherParameters = ''): void
    {
        $fulltextIndex = new FulltextIndex($name, $columns, $otherParameters);

        $this->assertEquals($name, $fulltextIndex->getName());
        $this->assertEquals($columns, $fulltextIndex->getColumns());
        $this->assertEquals($otherParameters, $fulltextIndex->getOtherParameters());
    }
}
