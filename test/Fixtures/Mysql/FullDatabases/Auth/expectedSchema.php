<?php declare(strict_types=1);

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumention\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table('user'))
            ->addColumn(
                new Column(
                    'user_id',
                    'INT',
                    [10],
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
            ->setPrimaryKey(new PrimaryKey(['user_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_actor_last_name',
                    ['last_name']
                )
            )
    )
    ->addTable(
        (new Table('developer'))
            ->addColumn(
                new Column(
                    'id',
                    'INT',
                    [10],
                    'UNSIGNED NOT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'VARCHAR',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'VARCHAR',
                    [32],
                    'COLLATE latin1_general_ci NOT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'nick',
                    'VARCHAR',
                    [16],
                    'COLLATE latin1_general_ci DEFAULT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'status',
                    'ENUM',
                    ['enabled', 'disabled'],
                    'COLLATE latin1_general_ci DEFAULT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'user_id',
                    'INT',
                    [10],
                    'UNSIGNED NOT NULL'
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_email_password',
                    ['email', 'password']
                )
            )
    )
    ->addTable(
        (new Table('log'))
            ->addColumn(
                new Column(
                    'id',
                    'INT',
                    [10],
                    'UNSIGNED NOT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'message',
                    'VARCHAR',
                    [64],
                    'COLLATE latin1_general_ci NOT NULL'
                )
            )
            ->addColumn(
                new Column(
                    'user_id',
                    'INT',
                    [10],
                    'UNSIGNED NOT NULL'
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'developer',
            'user',
            ['user_id'],
            ['user_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'log',
            'user',
            ['user_id'],
            ['user_id']
        )
    );
