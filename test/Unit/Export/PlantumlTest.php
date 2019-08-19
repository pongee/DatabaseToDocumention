<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\Export;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Schema;
use Pongee\DatabaseToDocumentation\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseToDocumentation\Export\Plantuml;

class PlantumlTest extends TestCase
{
    public function getSchamaProvider(): array
    {
        return [
            [
                (new Schema())
                    ->addTable(
                        (new Table())
                            ->setName('member')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', 'The id'))
                    ),
            ],
            [
                (new Schema())
                    ->addTable(
                        (new Table())
                            ->setName('member')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', 'The id'))
                    )
                    ->addTable(
                        (new Table())
                            ->setName('member_data')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', ''))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL', ''))
                            ->addColumn(new Column('type', 'VARCHAR', [64], 'NOT NULL', ''))
                            ->addColumn(new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL', ''))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_member_id', ['member_id'], 'USING HASH'))
                            ->addFullTextIndex(new FulltextIndex('idx_status', ['status']))
                            ->addSpatialIndex(new SpatialIndex('idx_type', ['type']))
                            ->addUniqueIndex(new UniqueIndex('idx_member_id', ['member_id'], 'USING HASH'))
                    )
                    ->addTable(
                        (new Table())
                            ->setName('member_log')
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT', 'The id'))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL', 'The member id'))
                            ->addColumn(new Column('log', 'VARCHAR', [255], 'NOT NULL', 'The log'))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_member_id', ['member_id'], 'USING HASH'))
                    )
                    ->addConnection(
                        new OneToOneConnection('member_data', 'member', ['member_id'], ['id'])
                    )
                    ->addConnection(
                        new OneToManyConnection('member_log', 'member', ['member_id'], ['id'])
                    ),
            ],
        ];
    }

    /**
     * @dataProvider getSchamaProvider
     */
    public function testExportTableWithColumns(SchemaInterface $schema)
    {
        $sut = new Plantuml(
            'tables:{{ tables.jsonSerialize()|json_encode|raw }}|connections:{{ connections.jsonSerialize()|json_encode()|raw }}'
        );

        $this->assertEquals(
            strtr(
                'tables:%tables%|connections:%connections%',
                [
                    '%tables%' => json_encode($schema->getTables()->jsonSerialize()),
                    '%connections%' => json_encode($schema->getConnections()->jsonSerialize()),
                ]
            ),
            $sut->export($schema)
        );
    }
}
