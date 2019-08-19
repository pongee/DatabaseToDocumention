<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Database\Table\Index;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKeyInterface;

class PrimaryKeyTest extends TestCase
{
    public function getPrimaryKeysProvider(): array
    {
        return [
            [
                ['member_id']
            ],
            [
                ['member_id'], 'USING HASH'
            ],
            [
                ['member_id', 'type']
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $primaryKey = new PrimaryKey([]);

        $this->assertInstanceOf(PrimaryKeyInterface::class, $primaryKey);
    }

    /**
     * @dataProvider getPrimaryKeysProvider
     */
    public function testIndex(array $columns, string $otherParameters = ''): void
    {
        $primaryKey = new PrimaryKey($columns, $otherParameters);

        $this->assertEquals($columns, $primaryKey->getColumns());
        $this->assertEquals($otherParameters, $primaryKey->getOtherParameters());
    }
}
