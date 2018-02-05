<?php declare(strict_types=1);

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseToDocumention\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table('user'))
            ->addColumn(
                new Column(
                    'user_id',
                    'INT',
                    [10],
                    'NOT NULL AUTO_INCREMENT'
                )
            )
            ->setPrimaryKey(new PrimaryKey(['user_id']))
    )
    ->addTable(
        (new Table('log'))
            ->addColumn(
                new Column(
                    'id',
                    'INT',
                    [10],
                    'NOT NULL AUTO_INCREMENT'
                )
            )
            ->addColumn(
                new Column(
                    'userId',
                    'INT',
                    [10],
                    'NOT NULL'
                )
            )
            ->setPrimaryKey(new PrimaryKey(['id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'log',
            'user',
            ['userId'],
            ['user_id']
        )
    );
