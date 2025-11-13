<?php
namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Core\Models\BorrowTransaction;

class BorrowTransactionTest extends TestCase
{
    public function testTransactionCanBeCreated(): void
    {
        $transaction = new BorrowTransaction(
            transactionId: 1,
            memberId: 1,
            resourceId: 1,
            borrowDate: '2025-11-01',
            dueDate: '2025-11-15',
            returnDate: null
        );

        $this->assertEquals(expected: 1, actual: $transaction->transactionId);
        $this->assertEquals(expected: 1, actual: $transaction->memberId);
        $this->assertEquals(expected: 1, actual: $transaction->resourceId);
        $this->assertEquals(expected: '2025-11-01', actual: $transaction->borrowDate);
        $this->assertEquals(expected: '2025-11-15', actual: $transaction->dueDate);
        $this->assertNull(actual: $transaction->returnDate);
    }

    public function testTransactionCanBeReturnedManually(): void
    {
        $transaction = new BorrowTransaction(
            transactionId: 1,
            memberId: 1,
            resourceId: 1,
            borrowDate: '2025-11-01',
            dueDate: '2025-11-15',
            returnDate: null
        );

        $this->assertNull(actual: $transaction->returnDate);
        $transaction->returnDate = date(format: 'Y-m-d');

        $this->assertNotNull(actual: $transaction->returnDate);
        $this->assertEquals(expected: date(format: 'Y-m-d'), actual: $transaction->returnDate);
    }

    public function testTransactionIsActiveWhenNotReturned(): void
    {
        $transaction = new BorrowTransaction(
            transactionId: 1,
            memberId: 1,
            resourceId: 1,
            borrowDate: '2025-11-01',
            dueDate: '2025-11-15',
            returnDate: null
        );

        $this->assertNull(actual: $transaction->returnDate);
    }

    public function testTransactionIsCompletedWhenReturned(): void
    {
        $transaction = new BorrowTransaction(
            transactionId: 1,
            memberId: 1,
            resourceId: 1,
            borrowDate: '2025-11-01',
            dueDate: '2025-11-15',
            returnDate: '2025-11-10'
        );

        $this->assertNotNull(actual: $transaction->returnDate);
    }
}

