<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\DataObject\Sql\Table\Database;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Schema;
use Pongee\DatabaseToDocumentation\DataObject\Sql\SchemaInterface;

class SchemaTest extends TestCase
{
    public function getTablesProvider(): array
    {
        return [
            [
                new Table(),
            ],
            [
                new Table(),
                new Table(),
                new Table(),
            ],
        ];
    }

    public function getConnectionProvider(): array
    {
        return [
            [
                new OneToOneConnection('member_data', 'member', ['member_id'], ['id']),
            ],
            [
                new OneToOneConnection('member_data', 'member', ['member_id'], ['member_id']),
                new OneToManyConnection('member_log', 'member', ['member_id'], ['member_id']),
            ],
        ];
    }

    public function testInstanceOf(): void
    {
        $schema = new Schema();

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    /**
     * @dataProvider getTablesProvider
     */
    public function testTable(TableInterface ...$tables): void
    {
        $schema = new Schema();

        foreach ($tables as $table) {
            $schema->addTable($table);
        }

        foreach ($schema->getTables() as $table) {
            $this->assertTrue(in_array($table, $tables, true));
        }
    }

    /**
     * @dataProvider getConnectionProvider
     */
    public function testConnection(ConnectionInterface ...$connections): void
    {
        $schema = new Schema();

        foreach ($connections as $connection) {
            $schema->addConnection($connection);
        }

        foreach ($schema->getConnections() as $connection) {
            $this->assertTrue(in_array($connection, $connections, true));
        }
    }
}
