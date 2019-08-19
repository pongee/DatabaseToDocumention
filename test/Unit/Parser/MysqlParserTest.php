<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\Parser;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollectionInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\TableInterface;
use Pongee\DatabaseToDocumentation\DataObject\Sql\SchemaInterface;
use Pongee\DatabaseToDocumentation\Parser\MysqlParser;
use RecursiveIteratorIterator;
use SplFileInfo;

class MysqlParserTest extends TestCase
{
    public function getSchemaProvider(): array
    {
        $directoryIterator = new RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(FIXTURES_DIRECTORY . '/Mysql/')
        );

        $providers = [];
        $directoryIterator->rewind();
        foreach ($directoryIterator as $file) {
            /** @var SplFileInfo $file */
            if ($file->isFile() && $file->getExtension() === 'sql') {
                $forcedConnections = new ConnectionCollection();
                $expendedSchemaPath = dirname($file->getRealPath()) . '/expectedSchema.php';
                $schemaObject = include $expendedSchemaPath;

                if (!$schemaObject instanceof SchemaInterface) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            '%s file is not a SchemaInterface',
                            $expendedSchemaPath
                        )
                    );
                }

                $forcedConnectionsPath = dirname($file->getRealPath()) . '/forcedConnection.php';
                if (is_readable($forcedConnectionsPath)) {
                    $forcedConnections = include $forcedConnectionsPath;

                    if (!$forcedConnections instanceof ConnectionCollectionInterface) {
                        throw new \InvalidArgumentException(
                            sprintf(
                                '%s file is not a ConnectionCollectionInterface',
                                $forcedConnections
                            )
                        );
                    }
                }

                $providers[] = [$file, $schemaObject, $forcedConnections];
            }
        }

        return $providers;
    }

    /**
     * @dataProvider getSchemaProvider
     */
    public function testParser(
        SplFileInfo $file,
        SchemaInterface $schemaObject,
        ConnectionCollectionInterface $forcedConnections
    ) {
        $sut = new MysqlParser();
        $result = $sut->run(file_get_contents($file->getRealPath()), $forcedConnections); //@todo

        foreach ($result->getTables() as $table) {
            $expectedTable = $schemaObject->getTables()->offsetGet($table->getName());

            $this->assertInstanceOf(
                TableInterface::class,
                $expectedTable,
                sprintf('Bad table. Schema: %s, table: %s', $file->getRealPath(), $table->getName())
            );

            foreach ($table->getColumns() as $columnName => $column) {
                $this->assertEquals(
                    $expectedTable->getColumns()->offsetGet($columnName),
                    $column,
                    sprintf(
                        "Bad column.\n Schema: %s \nTable: %s \nColumn: %s",
                        $file->getRealPath(),
                        $table->getName(),
                        $columnName
                    )
                );
            }

            $this->assertEquals(
                $expectedTable->getSimpleIndexs(),
                $table->getSimpleIndexs(),
                sprintf("Bad simple indexs. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->getName())
            );

            $this->assertEquals(
                $expectedTable->getUniqueIndexs(),
                $table->getUniqueIndexs(),
                sprintf("Bad unique indexs. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->getName())
            );

            $this->assertEquals(
                $expectedTable->getFulltextIndexs(),
                $table->getFulltextIndexs(),
                sprintf("Bad fulltext indexs. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->getName())
            );

            $this->assertEquals(
                $expectedTable->getSpatialIndexs(),
                $table->getSpatialIndexs(),
                sprintf("Bad spatial indexs. \nSchema: %s \ntable: %s", $file->getRealPath(), $table->getName())
            );

            $this->assertEquals(
                $expectedTable->getPrimaryKey(),
                $table->getPrimaryKey(),
                sprintf("Bad primary key. \nSchema: %s \nTable: %s", $file->getRealPath(), $table->getName())
            );
        }

        $this->assertEquals(
            $schemaObject->getConnections(),
            $result->getConnections(),
            sprintf('Schema %s', $file->getRealPath())
        );

        // Double checking
        $this->assertEquals($schemaObject, $result, sprintf('Schema %s', $file->getRealPath()));
    }
}
