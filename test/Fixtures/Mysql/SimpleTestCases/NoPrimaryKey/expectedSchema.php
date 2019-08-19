<?php declare(strict_types=1);

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table())
            ->setName('user')
            ->addColumn(
                new Column(
                    'user_id',
                    'int',
                    [10],
                    'NOT NULL AUTO_INCREMENT',
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
