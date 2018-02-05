<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\DataObject\Sql\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\OneToOneConnection;

class ConnectionCollectionTest extends TestCase
{
    public function getCollactionProvider(): array
    {
        return [
            [
                new OneToManyConnection('log', 'member', ['member_id'], ['id']),
            ],
            [
                new OneToOneConnection('member_data', 'member', ['member_id'], ['id']),
            ],
            [
                new OneToManyConnection('log', 'member', ['member_id'], ['id']),
                new OneToOneConnection('member_data', 'member', ['member_id'], ['id']),
                new OneToOneConnection('member_account', 'member', ['member_id'], ['id']),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $connectionCollection = new ConnectionCollection();

        $this->assertInstanceOf(ConnectionCollectionInterface::class, $connectionCollection);
    }

    /**
     * @dataProvider getCollactionProvider
     */
    public function testAddCollection(ConnectionInterface ...$connections): void
    {
        $connectionCollection = new ConnectionCollection();

        $connectionCollection->adds(...$connections);

        foreach ($connectionCollection as $i => $connection) {
            $this->assertTrue(in_array($connection, $connections));
        }

        $this->assertNull($connectionCollection->next());
        $this->assertNull($connectionCollection->key());
        $this->assertNull($connectionCollection->current());
        $this->assertFalse($connectionCollection->valid());

        $this->assertEquals($connections, $connectionCollection->toArray());
    }

    public function testEmptyCollection(): void
    {
        $connectionCollection = new ConnectionCollection();

        $this->assertNull($connectionCollection->next());
        $this->assertNull($connectionCollection->key());
        $this->assertNull($connectionCollection->current());
        $this->assertFalse($connectionCollection->valid());

        $this->assertEquals([], $connectionCollection->toArray());
    }
}
