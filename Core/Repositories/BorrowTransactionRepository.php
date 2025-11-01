<?php
namespace Core\Repositories;

class BorrowTransactionRepository
{
    private static $file = __DIR__ . '/../data/transactions.json';

    public static function findAll(): mixed
    {
        return DataStore::read(path: self::$file);
    }

    public static function add($transaction): void
    {
        $transactions = self::findAll();
        $transactions[] = $transaction;
        DataStore::write(path: self::$file, data: $transactions);
    }

    public static function findById($id): mixed
    {
        $transactions = self::findAll();
        foreach ($transactions as $transaction) {
            if ($transaction['transactionId'] == $id) {
                return $transaction;
            }
        }
        return null;
    }

    public static function findActiveByMemberId($memberId): array
    {
        $transactions = self::findAll();
        $active = [];
        foreach ($transactions as $transaction) {
            if ($transaction['memberId'] == $memberId && $transaction['returnDate'] === null) {
                $active[] = $transaction;
            }
        }
        return $active;
    }

    public static function findActiveByResourceId($resourceId): mixed
    {
        $transactions = self::findAll();
        foreach ($transactions as $transaction) {
            if ($transaction['resourceId'] == $resourceId && $transaction['returnDate'] === null) {
                return $transaction;
            }
        }
        return null;
    }

    public static function update($id, $updatedTransaction): bool
    {
        $transactions = self::findAll();
        foreach ($transactions as $index => $transaction) {
            if ($transaction['transactionId'] == $id) {
                $transactions[$index] = $updatedTransaction;
                DataStore::write(path: self::$file, data: $transactions);
                return true;
            }
        }
        return false;
    }

    public static function findOverdue(): array
    {
        $transactions = self::findAll();
        $overdue = [];
        $today = date('Y-m-d');
        foreach ($transactions as $transaction) {
            if ($transaction['returnDate'] === null && $transaction['dueDate'] < $today) {
                $overdue[] = $transaction;
            }
        }
        return $overdue;
    }
}

