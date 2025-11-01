<?php
namespace Core\Controllers;

use Core\Models\BorrowTransaction;
use Core\Repositories\BorrowTransactionRepository;
use Core\Repositories\BookRepository;
use Core\Repositories\OtherResourceRepository;
use Core\Repositories\MemberRepository;

class BorrowTransactionController
{
    public static function borrowResource($memberId, $resourceId, $daysToReturn = 14): array
    {
        // Check if member exists
        $member = MemberRepository::findById(id: $memberId);
        if (!$member) {
            return ['success' => false, 'message' => 'Member not found!'];
        }

        // Check if resource exists (check both books and other resources)
        $resource = BookRepository::findById(id: $resourceId);
        if (!$resource) {
            $resource = OtherResourceRepository::findById(id: $resourceId);
        }
        
        if (!$resource) {
            return ['success' => false, 'message' => 'Resource not found!'];
        }

        // Check if resource is already borrowed
        $existingTransaction = BorrowTransactionRepository::findActiveByResourceId(resourceId: $resourceId);
        if ($existingTransaction) {
            return ['success' => false, 'message' => 'Resource is already borrowed!'];
        }

        // Create transaction
        $transactions = BorrowTransactionRepository::findAll();
        $borrowDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime("+{$daysToReturn} days"));

        $transaction = new BorrowTransaction(
            transactionId: count($transactions) + 1,
            memberId: $memberId,
            resourceId: $resourceId,
            borrowDate: $borrowDate,
            dueDate: $dueDate,
            returnDate: null
        );

        BorrowTransactionRepository::add(transaction: $transaction);
        
        return [
            'success' => true,
            'message' => "Resource borrowed successfully! Due date: {$dueDate}",
            'transaction' => $transaction
        ];
    }

    public static function returnResource($transactionId): array
    {
        $transaction = BorrowTransactionRepository::findById(id: $transactionId);
        
        if (!$transaction) {
            return ['success' => false, 'message' => 'Transaction not found!'];
        }

        if ($transaction['returnDate'] !== null) {
            return ['success' => false, 'message' => 'Resource already returned!'];
        }

        // Update transaction
        $borrowTransaction = new BorrowTransaction(
            transactionId: $transaction['transactionId'],
            memberId: $transaction['memberId'],
            resourceId: $transaction['resourceId'],
            borrowDate: $transaction['borrowDate'],
            dueDate: $transaction['dueDate'],
            returnDate: date('Y-m-d')
        );

        BorrowTransactionRepository::update(id: $transactionId, updatedTransaction: $borrowTransaction);

        return ['success' => true, 'message' => 'Resource returned successfully!'];
    }

    public static function listAllTransactions(): array
    {
        return BorrowTransactionRepository::findAll();
    }

    public static function listActiveTransactions(): array
    {
        $transactions = BorrowTransactionRepository::findAll();
        return array_filter($transactions, fn($t) => $t['returnDate'] === null);
    }

    public static function listOverdueTransactions(): array
    {
        return BorrowTransactionRepository::findOverdue();
    }

    public static function getMemberTransactions($memberId): array
    {
        return BorrowTransactionRepository::findActiveByMemberId(memberId: $memberId);
    }

    public static function getTransaction($id): mixed
    {
        return BorrowTransactionRepository::findById(id: $id);
    }
}

