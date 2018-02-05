<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Test\Unit\Command\Mysql;

use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumention\Command\Mysql\MysqlJsonCommand;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumention\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseToDocumention\Parser\MysqlParser;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MysqlJsonCommandTest extends TestCase
{
    public function testName(): void
    {
        $this->assertNotEmpty($this->getCommand()->getName());
    }

    public function testDescription(): void
    {
        $this->assertNotEmpty($this->getCommand()->getDescription());
    }

    public function testSynopsis(): void
    {
        $this->assertEquals(
            'mysql:json [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand()->getSynopsis()
        );
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not enough arguments (missing: "file").
     */
    public function testNoParameters(): void
    {
        $parser = new MysqlParser();

        $command = new MysqlJsonCommand($parser, '');
        $command->run(
            new ArrayInput([]),
            new BufferedOutput()
        );
    }

    public function testCommand(): void
    {
        $fakeSqlName    = 'fake.sql';
        $fakeSqlContent = file_get_contents(FIXTURES_DIRECTORY . $fakeSqlName);

        $output = new BufferedOutput();

        $parser = $this->createMock(MysqlParser::class);
        $parser
            ->expects($this->once())
            ->method('run')
            ->with(
                $fakeSqlContent,
                (new ConnectionCollection())
                    ->add(new NotDefinedConnection('log', 'user', ['user_id'], ['user_id']))
            );

        $command = new MysqlJsonCommand($parser, FIXTURES_DIRECTORY);
        $command->run(
            new ArrayInput([
                'file'         => $fakeSqlName,
                '--connection' => ['log.user_id=>user.user_id']
            ]),
            $output
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'tables'      => [],
                'connections' => []
            ]),
            $output->fetch()
        );
    }

    private function getCommand(string $rootDir = ''): MysqlJsonCommand
    {
        /** @var MysqlParser $mysqlParser */
        $mysqlParser = $this->createMock(MysqlParser::class);

        return new MysqlJsonCommand($mysqlParser, $rootDir);
    }
}
