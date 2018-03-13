<?php declare(strict_types=1);

use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Table\Column;
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
                    'AUTO_INCREMENT',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_user_id',
                    ['user_id']
                )
            )
    );
