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
                    'INT',
                    [10],
                    'UNSIGNED NOT NULL',
                    'The id'
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'VARCHAR',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL',
                    'The email'
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'VARCHAR',
                    [32],
                    'COLLATE latin1_general_ci NOT NULL',
                    'The password'
                )
            )
            ->addColumn(
                new Column(
                    'nick',
                    'VARCHAR',
                    [16],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    'The nick'
                )
            )
            ->addColumn(
                new Column(
                    'status',
                    'ENUM',
                    ['enabled', 'disabled'],
                    'COLLATE latin1_general_ci DEFAULT NULL',
                    'The status flag'
                )
            )
            ->addColumn(
                new Column(
                    'admin',
                    'BIT',
                    [],
                    'NULL',
                    'The admin flag'
                )
            )
            ->addColumn(
                new Column(
                    'geom',
                    'GEOMETRY',
                    [],
                    'NOT NULL',
                    'The geom'
                )
            )
            ->addColumn(
                new Column(
                    'created_at',
                    'DATETIME',
                    [],
                    'NULL',
                    'The created at'
                )
            )
            ->addColumn(
                new Column(
                    'updated_at',
                    'DATETIME',
                    [],
                    'NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    'The updated at'
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
