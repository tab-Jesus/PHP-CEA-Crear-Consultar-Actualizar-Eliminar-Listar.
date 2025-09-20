<?php

namespace App\Application\Port\Out;

interface UnitOfWorkPort
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollback(): void;
    public function transaction(callable $callback);
    public function executeInTransaction(callable $callback);
    public function getTransactionLevel(): int;
    public function isInTransaction(): bool;
    public function clearTransaction(): void;
}
?>