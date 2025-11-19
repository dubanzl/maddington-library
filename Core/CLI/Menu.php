<?php
namespace Core\CLI;

use Core\CLI\Handlers\BookMenuHandler;
use Core\CLI\Handlers\MemberMenuHandler;
use Core\CLI\Handlers\OtherResourceMenuHandler;
use Core\CLI\Handlers\BorrowTransactionMenuHandler;

class Menu {
    public static function run(): void {
        ConsoleUI::title('Library Management System');
        
        $choice = ConsoleUI::choice(
            question: 'Select an option',
            choices: [
                'Books Menu',
                'Members Menu',
                'Other Resources Menu',
                'Borrow/Return Menu',
                'Exit'
            ]
        );

        match ($choice) {
            'Books Menu' => Menu::booksMenu(),
            'Members Menu' => Menu::membersMenu(),
            'Other Resources Menu' => Menu::otherResourcesMenu(),
            'Borrow/Return Menu' => Menu::borrowTransactionMenu(),
            'Exit' => ConsoleUI::info(text: 'Goodbye!'),
            default => Menu::run()
        };
    }

    public static function booksMenu(): void {
        ConsoleUI::title(title: 'Books Management');
        
        $choice = ConsoleUI::choice(
            question: 'Select an option',
            choices: [
                'Add Book',
                'List Books',
                'Edit Book',
                'Delete Book',
                'Back to Main Menu'
            ]
        );

        match ($choice) {
            'Add Book' => BookMenuHandler::add(),
            'List Books' => BookMenuHandler::list(),
            'Edit Book' => BookMenuHandler::edit(),
            'Delete Book' => BookMenuHandler::delete(),
            'Back to Main Menu' => null,
            default => null
        };

        if ($choice !== 'Back to Main Menu') {
            ConsoleUI::info('Press Enter to continue...');
            fgets(STDIN);
            Menu::booksMenu();
        } else {
            Menu::run();
        }
    }

    public static function membersMenu(): void {
        ConsoleUI::title('Members Management');
        
        $choice = ConsoleUI::choice(
            question: 'Select an option',
            choices: [
                'Add Member',
                'List Members',
                'Back to Main Menu'
            ]
        );

        match ($choice) {
            'Add Member' => MemberMenuHandler::add(),
            'List Members' => MemberMenuHandler::list(),
            'Back to Main Menu' => null,
            default => null
        };

        if ($choice !== 'Back to Main Menu') {
            ConsoleUI::info('Press Enter to continue...');
            fgets(STDIN);
            Menu::membersMenu();
        } else {
            Menu::run();
        }
    }

    public static function otherResourcesMenu(): void {
        ConsoleUI::title('Other Resources Management');
        
        $choice = ConsoleUI::choice(
            question: 'Select an option',
            choices: [
                'Add Resource',
                'List Resources',
                'Edit Resource',
                'Delete Resource',
                'Back to Main Menu'
            ]
        );

        match ($choice) {
            'Add Resource' => OtherResourceMenuHandler::add(),
            'List Resources' => OtherResourceMenuHandler::list(),
            'Edit Resource' => OtherResourceMenuHandler::edit(),
            'Delete Resource' => OtherResourceMenuHandler::delete(),
            'Back to Main Menu' => null,
            default => null
        };

        if ($choice !== 'Back to Main Menu') {
            ConsoleUI::info('Press Enter to continue...');
            fgets(STDIN);
            Menu::otherResourcesMenu();
        } else {
            Menu::run();
        }
    }

    public static function borrowTransactionMenu(): void {
        ConsoleUI::title('Borrow/Return Management');
        
        $choice = ConsoleUI::choice(
            question: 'Select an option',
            choices: [
                'Borrow Resource',
                'Return Resource',
                'All Transactions',
                'Active Borrowings',
                'Overdue Transactions',
                'Back to Main Menu'
            ]
        );

        match ($choice) {
            'Borrow Resource' => BorrowTransactionMenuHandler::borrowResource(),
            'Return Resource' => BorrowTransactionMenuHandler::returnResource(),
            'All Transactions' => BorrowTransactionMenuHandler::listAllTransactions(),
            'Active Borrowings' => BorrowTransactionMenuHandler::listActiveTransactions(),
            'Overdue Transactions' => BorrowTransactionMenuHandler::listOverdueTransactions(),
            'Back to Main Menu' => null,
            default => null
        };

        if ($choice !== 'Back to Main Menu') {
            ConsoleUI::info('Press Enter to continue...');
            fgets(STDIN);
            Menu::borrowTransactionMenu();
        } else {
            Menu::run();
        }
    }
}
