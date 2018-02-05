<?php declare(strict_types=1);

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table('user'))
            ->addColumn(
                new Column(
                    'id',
                    'int',
                    [10],
                    'unsigned not null'
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'varchar',
                    [64],
                    'collate latin1_general_ci not null'
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'varchar',
                    [32],
                    'collate latin1_general_ci not null'
                )
            )
            ->addColumn(
                new Column(
                    'nick',
                    'varchar',
                    [16],
                    'collate latin1_general_ci default null'
                )
            )
            ->addColumn(
                new Column(
                    'status',
                    'enum',
                    ['enabled', 'disabled'],
                    'collate latin1_general_ci default null'
                )
            )
            ->addColumn(
                new Column(
                    'admin',
                    'bit',
                    [],
                    'null'
                )
            )
            ->addColumn(
                new Column(
                    'geom',
                    'geometry',
                    [],
                    'not null'
                )
            )
            ->addColumn(
                new Column(
                    'created_at',
                    'datetime',
                    [],
                    'null'
                )
            )
            ->addColumn(
                new Column(
                    'updated_at',
                    'datetime',
                    [],
                    'null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'i_password',
                    ['password']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'ih_password',
                    ['password']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'ib_password',
                    ['password']
                )
            )
            ->addFullTextIndex(
                new FulltextIndex(
                    'if_email_password',
                    ['email', 'password']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iu_email_password',
                    ['nick']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iuh_email_password',
                    ['nick']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iub_email_password',
                    ['nick']
                )
            )
    );