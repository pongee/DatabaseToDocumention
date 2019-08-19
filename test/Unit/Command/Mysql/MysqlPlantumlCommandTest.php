<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\Test\Unit\Command\Mysql;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pongee\DatabaseToDocumentation\Command\Mysql\MysqlPlantumlCommand;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\ConnectionCollection;
use Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection\NotDefinedConnection;
use Pongee\DatabaseToDocumentation\Parser\MysqlParser;
use RuntimeException as RuntimeExceptionAlias;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MysqlPlantumlCommandTest extends TestCase
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
            'mysql:plantuml [-t|--template [TEMPLATE]] [-c|--connection CONNECTION] [--] <file>',
            $this->getCommand()->getSynopsis()
        );
    }

    public function testRunWithNoParameters(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "file").');

        $command = $this->getCommand();
        $command->run(
            new ArrayInput([]),
            new BufferedOutput()
        );
    }

    public function testRunWithBadSqlPath(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Bad sql file path.');

        $command = $this->getCommand(FIXTURES_DIRECTORY);
        $command->run(
            new ArrayInput([
                'file' => 'badSqlFile.sql'
            ]),
            new BufferedOutput()
        );
    }

    public function testRunWithBadTemplatePath(): void
    {
        $this->expectException(RuntimeExceptionAlias::class);
        $this->expectExceptionMessage('Bad template file path.');

        $command = $this->getCommand(FIXTURES_DIRECTORY);
        $command->run(
            new ArrayInput([
                'file'       => 'fake.sql',
                '--template' => 'badTemplateFile.twig',
            ]),
            new BufferedOutput()
        );
    }

    public function testRunWithAllParameters(): void
    {
        $fakeSqlName         = 'fake.sql';
        $fakeSqlContent      = file_get_contents(FIXTURES_DIRECTORY . $fakeSqlName);
        $fakeTemplateName    = 'fake.twig';
        $fakeTemplateContent = file_get_contents(FIXTURES_DIRECTORY . 'fake.twig');

        $output = new BufferedOutput();

        /** @var MysqlParser|MockObject $parser */
        $parser = $this->createMock(MysqlParser::class);
        $parser
            ->expects($this->once())
            ->method('run')
            ->with(
                $fakeSqlContent,
                (new ConnectionCollection())
                    ->add(new NotDefinedConnection('log', 'user', ['user_id'], ['user_id']))
            );

        $sut = new MysqlPlantumlCommand($parser, FIXTURES_DIRECTORY);
        $sut->run(
            new ArrayInput([
                'file'         => $fakeSqlName,
                '--template'   => $fakeTemplateName,
                '--connection' => ['log.user_id=>user.user_id'],
            ]),
            $output
        );

        $this->assertEquals($fakeTemplateContent, $output->fetch());
    }

    private function getCommand(string $rootDir = ''): MysqlPlantumlCommand
    {
        /** @var MysqlParser $mysqlParser */
        $mysqlParser = $this->createMock(MysqlParser::class);

        return new MysqlPlantumlCommand($mysqlParser, $rootDir);
    }
}
