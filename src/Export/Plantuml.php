<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumention\Export;

use Pongee\DatabaseToDocumention\DataObject\Sql\SchemaInterface;

class Plantuml implements ExportInterface
{
    /** @var \Twig_Environment */
    protected $twig;

    public function __construct(string $template)
    {
        $this->twig = new \Twig_Environment(
            new \Twig_Loader_Array([
                'template' => $template,
            ])
        );
    }

    public function export(SchemaInterface $schema): string
    {
        $text = $this->twig->render(
            'template',
            [
                'tables'      => $schema->getTables(),
                'connections' => $schema->getConnections(),
            ]
        );

        $text = preg_replace('/^\s+/m', '', $text);

        return strtr(
            $text,
            [
                '[\t]' => "\t",
                '[\n]' => "",
            ]
        );
    }
}
