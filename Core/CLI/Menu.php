<?php
namespace Core\CLI;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\CliMenu;
use Core\CLI\Handlers\BookMenuHandler;
use Core\CLI\Handlers\MemberMenuHandler;
use Core\CLI\Handlers\OtherResourceMenuHandler;
use Core\CLI\Handlers\BorrowTransactionMenuHandler;

class Menu {
    public static function run(): void {
        $menu = (new CliMenuBuilder)
            ->setTitle(title: 'Library Management System')
            ->addItem(text: 'Books Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::booksMenu();
            })
            ->addItem(text: 'Members Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::membersMenu();
            })
            ->addItem(text: 'Other Resources Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::otherResourcesMenu();
            })
            ->addItem(text: 'Borrow/Return Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::borrowTransactionMenu();
            })
            ->addLineBreak(breakChar: '-')
            ->build();

        $menu->open();
    }

    public static function booksMenu(): void {
        $menu = (new CliMenuBuilder)
            ->setTitle(title: 'Books Management')
            ->addItem(text: 'Add Book', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BookMenuHandler::add();
                Menu::booksMenu();
            })
            ->addItem(text: 'List Books', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BookMenuHandler::list();
                Menu::booksMenu();
            })
            ->addItem(text: 'Edit Book', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BookMenuHandler::edit();
                Menu::booksMenu();
            })
            ->addItem(text: 'Delete Book', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BookMenuHandler::delete();
                Menu::booksMenu();
            })
            ->addLineBreak(breakChar: '-')
            ->addItem(text: 'Back to Main Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::run();
            })
            ->build();

        $menu->open();
    }

    public static function membersMenu(): void {
        $menu = (new CliMenuBuilder)
            ->setTitle(title: 'Members Management')
            ->addItem(text: 'Add Member', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                MemberMenuHandler::add();
                Menu::membersMenu();
            })
            ->addItem(text: 'List Members', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                MemberMenuHandler::list();
                Menu::membersMenu();
            })
            ->addLineBreak(breakChar: '-')
            ->addItem(text: 'Back to Main Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::run();
            })
            ->build();

        $menu->open();
    }

    public static function otherResourcesMenu(): void {
        $menu = (new CliMenuBuilder)
            ->setTitle(title: 'Other Resources Management')
            ->addItem(text: 'Add Resource', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                OtherResourceMenuHandler::add();
                Menu::otherResourcesMenu();
            })
            ->addItem(text: 'List Resources', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                OtherResourceMenuHandler::list();
                Menu::otherResourcesMenu();
            })
            ->addItem(text: 'Edit Resource', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                OtherResourceMenuHandler::edit();
                Menu::otherResourcesMenu();
            })
            ->addItem(text: 'Delete Resource', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                OtherResourceMenuHandler::delete();
                Menu::otherResourcesMenu();
            })
            ->addLineBreak(breakChar: '-')
            ->addItem(text: 'Back to Main Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::run();
            })
            ->build();

        $menu->open();
    }

    public static function borrowTransactionMenu(): void {
        $menu = (new CliMenuBuilder)
            ->setTitle(title: 'Borrow/Return Management')
            ->addItem(text: 'Borrow Resource', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BorrowTransactionMenuHandler::borrowResource();
                Menu::borrowTransactionMenu();
            })
            ->addItem(text: 'Return Resource', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BorrowTransactionMenuHandler::returnResource();
                Menu::borrowTransactionMenu();
            })
            ->addItem(text: 'All Transactions', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BorrowTransactionMenuHandler::listAllTransactions();
                Menu::borrowTransactionMenu();
            })
            ->addItem(text: 'Active Borrowings', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BorrowTransactionMenuHandler::listActiveTransactions();
                Menu::borrowTransactionMenu();
            })
            ->addItem(text: 'Overdue Transactions', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                BorrowTransactionMenuHandler::listOverdueTransactions();
                Menu::borrowTransactionMenu();
            })
            ->addLineBreak(breakChar: '-')
            ->addItem(text: 'Back to Main Menu', itemCallable: function (CliMenu $menu): void {
                $menu->close();
                Menu::run();
            })
            ->build();

        $menu->open();
    }
}
