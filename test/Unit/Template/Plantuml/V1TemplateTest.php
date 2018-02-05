<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\Tempalte\Plantuml;

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
use Pongee\DatabaseToDocumention\Export\Plantuml;

class V1TemplateTest extends TestCase
{
    /** @var Plantuml */
    protected $plantuml;

    public function getSchemaProvider(): array
    {
        return [
            [
                (new Schema())
                    ->addTable(
                        (new Table('actor'))
                            ->addColumn(
                                new Column(
                                    'actor_id',
                                    'SMALLINT',
                                    [],
                                    'UNSIGNED NOT NULL AUTO_INCREMENT'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'first_name',
                                    'VARCHAR',
                                    [45],
                                    'NOT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'last_name',
                                    'VARCHAR',
                                    [45],
                                    'NOT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'last_update',
                                    'TIMESTAMP',
                                    [],
                                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
                                )
                            )
                    )
                    ->addTable(
                        (new Table('address'))
                            ->addColumn(
                                new Column(
                                    'address_id',
                                    'SMALLINT',
                                    [],
                                    'UNSIGNED UNSIGNED NOT NULL AUTO_INCREMENT'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'address',
                                    'VARCHAR',
                                    [50],
                                    'NOT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'address2',
                                    'VARCHAR',
                                    [50],
                                    'DEFAULT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'district',
                                    'VARCHAR',
                                    [20],
                                    'NOT NULL'
                                )
                            )
                    ),
                "
table(actor) {
    column('actor_id', 'SMALLINT', 'UNSIGNED NOT NULL AUTO_INCREMENT')
    column('first_name', 'VARCHAR[45]', 'NOT NULL')
    column('last_name', 'VARCHAR[45]', 'NOT NULL')
    column('last_update', 'TIMESTAMP', 'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
}
table(address) {
    column('address_id', 'SMALLINT', 'UNSIGNED UNSIGNED NOT NULL AUTO_INCREMENT')
    column('address', 'VARCHAR[50]', 'NOT NULL')
    column('address2', 'VARCHAR[50]', 'DEFAULT NULL')
    column('district', 'VARCHAR[20]', 'NOT NULL')
}
",
            ],
            [
                (new Schema())
                    ->addTable(
                        (new Table('member'))
                            ->addColumn(
                                new Column(
                                    'id',
                                    'INT',
                                    [10],
                                    'NOT NULL DEFAULT'
                                )
                            )
                    ),
                "
table(member) {
    column('id', 'INT[10]', 'NOT NULL DEFAULT')
}
",
            ],
            [
                (new Schema())
                    ->addTable(
                        (new Table('member'))
                            ->addColumn(
                                new Column(
                                    'id',
                                    'INT',
                                    [10],
                                    'NOT NULL DEFAULT'
                                )
                            )
                            ->setPrimaryKey(new PrimaryKey(['id']))
                    )
                    ->addTable(
                        (new Table('member_data'))
                            ->addColumn(
                                new Column(
                                    'id',
                                    'INT',
                                    [10],
                                    'NOT NULL DEFAULT'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'member_id',
                                    'INT',
                                    [10],
                                    'NOT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'type',
                                    'VARCHAR',
                                    [64],
                                    'NOT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'status',
                                    'ENUM',
                                    ['enabled', 'deleted'],
                                    'DEFAULT NULL'
                                )
                            )
                            ->setPrimaryKey(
                                new PrimaryKey(
                                    ['id'],
                                    'USING HASH'
                                )
                            )
                            ->addSimpleIndex(
                                new SimpleIndex(
                                    'idx_type',
                                    ['type']
                                )
                            )
                            ->addSimpleIndex(
                                new SimpleIndex(
                                    'idx_type_status',
                                    ['type', 'status'],
                                    'USING HASH'
                                )
                            )
                            ->addUniqueIndex(
                                new UniqueIndex(
                                    'idx_member_id',
                                    ['member_id']
                                )
                            )
                    )
                    ->addTable(
                        (new Table('member_log'))
                            ->addColumn(
                                new Column(
                                    'id',
                                    'INT',
                                    [10],
                                    'NOT NULL DEFAULT'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'member_id',
                                    'INT',
                                    [10],
                                    'NOT NULL'
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'action',
                                    'ENUM',
                                    ['login', 'logout'],
                                    ''
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'message',
                                    'VARCHAR',
                                    [64],
                                    ''
                                )
                            )
                            ->addColumn(
                                new Column(
                                    'created_at',
                                    'DATETIME',
                                    [],
                                    'NOT NULL'
                                )
                            )
                            ->setPrimaryKey(
                                new PrimaryKey(
                                    ['id'],
                                    'USING HASH'
                                )
                            )
                            ->addSimpleIndex(
                                new SimpleIndex(
                                    'idx_action',
                                    ['action']
                                )
                            )
                            ->addUniqueIndex(
                                new UniqueIndex(
                                    'idx_member_id',
                                    ['member_id'],
                                    'USING HASH'
                                )
                            )
                            ->addFullTextIndex(
                                new FulltextIndex(
                                    'idx_member_id_action',
                                    ['member_id', 'action']
                                )
                            )
                            ->addFullTextIndex(
                                new FulltextIndex(
                                    'idx_hash_member_id_action',
                                    ['member_id', 'action'],
                                    'USING HASH'
                                )
                            )
                            ->addSpatialIndex(
                                new SpatialIndex(
                                    'idx_message',
                                    ['message']
                                )
                            )
                            ->addSpatialIndex(
                                new SpatialIndex(
                                    'idx_hash_member_id_action',
                                    ['member_id', 'action'],
                                    'USING HASH'
                                )
                            )
                    )
                    ->addConnection(
                        new OneToOneConnection(
                            'member_data',
                            'member',
                            ['member_id'],
                            ['id']
                        )
                    )
                    ->addConnection(
                        new OneToManyConnection(
                            'member_log',
                            'member',
                            ['member_id'],
                            ['id']
                        )
                    ),
                "
table(member) {
    column('id', 'INT[10]', 'NOT NULL DEFAULT')
    primary_key('id')
}
table(member_data) {
    column('id', 'INT[10]', 'NOT NULL DEFAULT')
    column('member_id', 'INT[10]', 'NOT NULL')
    column('type', 'VARCHAR[64]', 'NOT NULL')
    column('status', 'ENUM[enabled, deleted]', 'DEFAULT NULL')
    primary_key('id', 'USING HASH')
    index('type')
    index('type, status', 'USING HASH')
    unique_index('member_id')
}
table(member_log) {
    column('id', 'INT[10]', 'NOT NULL DEFAULT')
    column('member_id', 'INT[10]', 'NOT NULL')
    column('action', 'ENUM[login, logout]')
    column('message', 'VARCHAR[64]')
    column('created_at', 'DATETIME', 'NOT NULL')
    primary_key('id', 'USING HASH')
    index('action')
    unique_index('member_id', 'USING HASH')
    fulltext_index('member_id, action')
    fulltext_index('member_id, action', 'USING HASH')
    spatial_index('message')
    spatial_index('member_id, action', 'USING HASH')
}
connection_one_to_one(member_data, member)
connection_one_to_many(member_log, member)
",
            ],
        ];
    }

    /**
     * @dataProvider getSchemaProvider
     */
    public function testExport(SchemaInterface $schema, string $extendOutput)
    {
        $template = file_get_contents(__DIR__ . '/../../../../src/Template/Plantuml/v1.twig');

        $plantuml = new Plantuml($template);

        $this->assertEquals(
            $this->trim($extendOutput),
            $this->trim($plantuml->export($schema))
        );
    }

    protected function trim($text)
    {
        return trim(
            preg_replace(
                '/^\s+/m',
                '',
                $text
            )
        );
    }
}
