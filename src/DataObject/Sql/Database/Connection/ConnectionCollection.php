<?php declare(strict_types=1);

namespace Pongee\DatabaseToDocumentation\DataObject\Sql\Database\Connection;

class ConnectionCollection implements ConnectionCollectionInterface
{
    /** @var ConnectionInterface[] */
    private $connections = [];

    public function add(ConnectionInterface $connection): self
    {
        $this->connections[] = $connection;

        return $this;
    }

    public function adds(ConnectionInterface ...$connections): self
    {
        foreach ($connections as $connection) {
            $this->add($connection);
        }

        return $this;
    }

    public function rewind(): void
    {
        reset($this->connections);
    }

    public function current(): ?ConnectionInterface
    {
        return current($this->connections) ?: null;
    }

    public function key(): ?int
    {
        return key($this->connections) ?: null;
    }

    public function next(): ?ConnectionInterface
    {
        return next($this->connections) ?: null;
    }

    public function valid(): bool
    {
        return $this->current() instanceof ConnectionInterface;
    }

    public function toArray(): array
    {
        return $this->connections;
    }
}
