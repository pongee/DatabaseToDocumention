<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Export;

use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Table\Index\IndexInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\SchemaInterface;

class Json implements ExportInterface
{
    public function export(SchemaInterface $schema): string
    {
        $return = [
            'tables' => [],
            'connections' => [],
        ];

        foreach ($schema->getTables() as $table) {
            $return['tables'][$table->getName()] = [
                'columns' => $this->getColumns($table),
                'indexs' => [
                    'simple' => $this->getSimpleIndexs($table),
                    'spatial' => $this->getSpatialIndexs($table),
                    'fulltext' => $this->getFulltextIndexs($table),
                    'unique' => $this->getUniqueIndexs($table),
                ],
                'primaryKey' => $this->getPrimiaryKey($table),
            ];
        }

        foreach ($schema->getConnections() as $connection) {
            $return['connections'][] = $this->getConnction($connection);
        }

        return json_encode(
            $return,
            JSON_PRETTY_PRINT
        );
    }

    private function getConnction(ConnectionInterface $connection): array
    {
        return [
            'type' => $connection->getType(),
            'childTableName' => $connection->getChildTableName(),
            'childTableColumns' => $connection->getChildTableColumns(),
            'parentTableName' => $connection->getParentTableName(),
            'parentTableColumns' => $connection->getParentTableColumns(),
        ];
    }

    private function getPrimiaryKey(TableInterface $table): array
    {
        if ($table->getPrimaryKey()) {
            return [
                'columns' => $table->getPrimaryKey()->getColumns(),
                'otherParameters' => $table->getPrimaryKey()->getOtherParameters(),
            ];
        }

        return [];
    }

    private function getColumns(TableInterface $table): array
    {
        $columns = [];
        foreach ($table->getColumns() as $column) {
            $columns[] = [
                'name' => $column->getName(),
                'type' => $column->getType(),
                'typeParameters' => $column->getTypeParameters(),
                'otherParameters' => $column->getOtherParameters(),
                'comment' => $column->getComment(),
            ];
        }

        return $columns;
    }

    private function getIndexData(IndexInterface $index): array
    {
        return [
            'name' => $index->getName(),
            'columns' => $index->getColumns(),
            'otherParameters' => $index->getOtherParameters(),
        ];
    }

    private function getSimpleIndexs(TableInterface $table): array
    {
        $indexs = [];
        foreach ($table->getSimpleIndexs() as $index) {
            $indexs[] = $this->getIndexData($index);
        }

        return $indexs;
    }

    private function getFulltextIndexs(TableInterface $table): array
    {
        $indexs = [];
        foreach ($table->getFulltextIndexs() as $index) {
            $indexs[] = $this->getIndexData($index);
        }

        return $indexs;
    }

    private function getUniqueIndexs(TableInterface $table): array
    {
        $indexs = [];
        foreach ($table->getUniqueIndexs() as $index) {
            $indexs[] = $this->getIndexData($index);
        }

        return $indexs;
    }

    private function getSpatialIndexs(TableInterface $table): array
    {
        $indexs = [];
        foreach ($table->getSpatialIndexs() as $index) {
            $indexs[] = $this->getIndexData($index);
        }

        return $indexs;
    }
}
