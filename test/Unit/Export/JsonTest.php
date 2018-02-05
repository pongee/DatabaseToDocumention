<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\Export;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Schema;
use Pongee\DatabaseToDocumention\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseToDocumention\Export\Json;

class JsonTest extends TestCase
{
    public function getSchamaProvider(): array
    {
        return [
            [
                (new Schema())
                    ->addTable(
                        (new Table('member'))
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT'))
                    ),
                '
{
    "tables": {
        "member": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT"
                }
            ],
            "indexs": {"simple": [], "spatial": [], "fulltext": [], "unique": []},
            "primaryKey": []
        }
    },
    "connections": []
}
',
            ],
            [
                (new Schema())
                    ->addTable(
                        (new Table('member'))
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT'))
                    )
                    ->addTable(
                        (new Table('member_data'))
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT'))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL'))
                            ->addColumn(new Column('type', 'VARCHAR', [64], 'NOT NULL'))
                            ->addColumn(new Column('status', 'ENUM', ['enabled', 'deleted'], 'DEFAULT NULL'))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_member_id', ['member_id'], 'USING HASH'))
                            ->addFullTextIndex(new FulltextIndex('idx_status', ['status']))
                            ->addSpatialIndex(new SpatialIndex('idx_type', ['type']))
                            ->addUniqueIndex(new UniqueIndex('idx_member_id', ['member_id'], 'USING HASH'))
                    )
                    ->addTable(
                        (new Table('member_log'))
                            ->addColumn(new Column('id', 'INT', [10], 'NOT NULL DEFAULT'))
                            ->addColumn(new Column('member_id', 'INT', [10], 'NOT NULL'))
                            ->addColumn(new Column('log', 'VARCHAR', [255], 'NOT NULL'))
                            ->setPrimaryKey(new PrimaryKey(['id'], 'USING HASH'))
                            ->addSimpleIndex(new SimpleIndex('idx_member_id', ['member_id'], 'USING HASH'))
                    )
                    ->addConnection(
                        new OneToOneConnection('member_data', 'member', ['member_id'], ['id'])
                    )
                    ->addConnection(
                        new OneToManyConnection('member_log', 'member', ['member_id'], ['id'])
                    ),
                '
{
    "tables": {
        "member": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT"
                }
            ],
            "indexs": {"simple": [], "spatial": [], "fulltext": [], "unique": []},
            "primaryKey": []
        },
        "member_data": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT"
                },
                {
                    "name": "member_id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL"
                },
                {
                    "name": "type",
                    "type": "VARCHAR",
                    "typeParameters": [64],
                    "otherParameters": "NOT NULL"
                },
                {
                    "name": "status",
                    "type": "ENUM",
                    "typeParameters": ["enabled","deleted"],
                    "otherParameters": "DEFAULT NULL"
                }
            ],
            "indexs": {
                "simple": [
                    {
                        "name": "idx_member_id",
                        "columns": ["member_id"],
                        "otherParameters": "USING HASH"
                    }
                ],
                "spatial": [
                    {
                        "name": "idx_type",
                        "columns": [
                            "type"
                        ],
                        "otherParameters": ""
                    }
                ],
                "fulltext": [
                    {
                        "name": "idx_status",
                        "columns": [
                            "status"
                        ],
                        "otherParameters": ""
                    }
                ],
                "unique": [
                    {
                        "name": "idx_member_id",
                        "columns": ["member_id"],
                        "otherParameters": "USING HASH"
                    }
                ]
            },
            "primaryKey": {
                "columns": ["id"],
                "otherParameters": "USING HASH"
            }
        },
        "member_log": {
            "columns": [
                {
                    "name": "id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL DEFAULT"
                },
                {
                    "name": "member_id",
                    "type": "INT",
                    "typeParameters": [10],
                    "otherParameters": "NOT NULL"
                },
                {
                    "name": "log",
                    "type": "VARCHAR",
                    "typeParameters": [255],
                    "otherParameters": "NOT NULL"
                }
            ],
            "indexs": {
                "simple": [
                    {
                        "name": "idx_member_id",
                        "columns": ["member_id"],
                        "otherParameters": "USING HASH"
                    }
                ],
                "spatial": [],
                "fulltext": [],
                "unique": []
            },
            "primaryKey": {
                "columns": ["id"],
                "otherParameters": "USING HASH"
            }
        }
    },
    "connections": [
        {
            "type": "OneToOne",
            "childTableName": "member_data",
            "childTableColumns": ["member_id"],
            "parentTableName": "member",
            "parentTableColumns": ["id"]
        },
        {
            "type": "OneToMany",
            "childTableName": "member_log",
            "childTableColumns": ["member_id"],
            "parentTableName": "member",
            "parentTableColumns": ["id"]
        }
    ]
}
',
            ],
        ];
    }

    /**
     * @dataProvider getSchamaProvider
     */
    public function testExportTableWithColumns(SchemaInterface $schema, string $expectedJson)
    {
        $plantuml = new Json();

        $this->assertJsonStringEqualsJsonString($expectedJson, $plantuml->export($schema));
    }
}
