<?php
namespace Core\CLI\Handlers;

use Core\CLI\ConsoleUI;
use Core\Controllers\BorrowTransactionController;
use Core\Controllers\BookController;
use Core\Controllers\MemberController;

class BorrowTransactionMenuHandler
{
    public static function borrowResource(): void
    {
        ConsoleUI::title(title: "Borrow Resource");

        // Show available members
        $members = MemberController::listMembers();
        if (empty($members)) {
            ConsoleUI::warning(text: "No members registered. Please add members first.");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        $memberRows = array_map(
            fn($m): array => [$m['memberId'], $m['memberName'], $m['email']],
            $members
        );
        ConsoleUI::table(headers: ['ID', 'Name', 'Email'], rows: $memberRows);

        $memberId = ConsoleUI::ask(question: "Enter Member ID");

        // Show available books
        echo "\n";
        $books = BookController::listBooks();
        if (!empty($books)) {
            $bookRows = array_map(
                fn($b): array => [$b['resourceId'], $b['name'], $b['author']['authorName']],
                $books
            );
            ConsoleUI::table(headers: ['ID', 'Book', 'Author'], rows: $bookRows);
        }

        $resourceId = ConsoleUI::ask(question: "Enter Resource ID to borrow");
        $days = ConsoleUI::ask(question: "Days to return (default: 14)", default: "14");

        $result = BorrowTransactionController::borrowResource(
            memberId: $memberId,
            resourceId: $resourceId,
            daysToReturn: (int)$days
        );

        if ($result['success']) {
            ConsoleUI::success(message: $result['message']);
        } else {
            ConsoleUI::warning(text: $result['message']);
        }

        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function returnResource(): void
    {
        ConsoleUI::title(title: "Return Resource");

        $activeTransactions = BorrowTransactionController::listActiveTransactions();

        if (empty($activeTransactions)) {
            ConsoleUI::warning(text: "No active borrowings found.");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        self::displayTransactionsTable(transactions: $activeTransactions);

        $transactionId = ConsoleUI::ask(question: "Enter Transaction ID to return");

        $result = BorrowTransactionController::returnResource(transactionId: $transactionId);

        if ($result['success']) {
            ConsoleUI::success(message: $result['message']);
        } else {
            ConsoleUI::warning(text: $result['message']);
        }

        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function listAllTransactions(): void
    {
        ConsoleUI::title(title: "All Transactions");
        $transactions = BorrowTransactionController::listAllTransactions();

        if (empty($transactions)) {
            ConsoleUI::warning(text: "No transactions found.");
        } else {
            self::displayTransactionsTable(transactions: $transactions);
        }

        ConsoleUI::info(text: "Press Enter to go back...");
        fgets(stream: STDIN);
    }

    public static function listActiveTransactions(): void
    {
        ConsoleUI::title(title: "Active Borrowings");
        $transactions = BorrowTransactionController::listActiveTransactions();

        if (empty($transactions)) {
            ConsoleUI::warning(text: "No active borrowings found.");
        } else {
            self::displayTransactionsTable(transactions: $transactions);
        }

        ConsoleUI::info(text: "Press Enter to go back...");
        fgets(stream: STDIN);
    }

    public static function listOverdueTransactions(): void
    {
        ConsoleUI::title(title: "Overdue Transactions");
        $transactions = BorrowTransactionController::listOverdueTransactions();

        if (empty($transactions)) {
            ConsoleUI::success(message: "No overdue transactions! All returns are on time.");
        } else {
            ConsoleUI::warning(text: "The following transactions are overdue:");
            self::displayTransactionsTable(transactions: $transactions);
        }

        ConsoleUI::info(text: "Press Enter to go back...");
        fgets(stream: STDIN);
    }

    private static function displayTransactionsTable(array $transactions): void
    {
        $rows = array_map(
            fn($t): array => [
                $t['transactionId'],
                $t['memberId'],
                $t['resourceId'],
                $t['borrowDate'],
                $t['dueDate'],
                $t['returnDate'] ?? 'Not Returned'
            ],
            $transactions
        );
        ConsoleUI::table(
            headers: ['TX ID', 'Member ID', 'Resource ID', 'Borrow Date', 'Due Date', 'Return Date'],
            rows: $rows
        );
    }
}

