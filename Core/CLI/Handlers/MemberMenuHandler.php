<?php
namespace Core\CLI\Handlers;

use Core\CLI\ConsoleUI;
use Core\Controllers\MemberController;

class MemberMenuHandler
{
    public static function add(): void
    {
        ConsoleUI::title(title: "Register Member");

        $name = ConsoleUI::ask(question: "Name");
        $email = ConsoleUI::ask(question: "Email");
        $phone = ConsoleUI::ask(question: "Phone");

        MemberController::addMember(name: $name, email: $email, phone: $phone);
        ConsoleUI::success(message: "Member added successfully!");
        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function list(): void
    {
        ConsoleUI::title(title: "Members");
        $members = MemberController::listMembers();

        if (empty($members)) {
            ConsoleUI::warning(text: "No members found.");
        } else {
            $rows = array_map(
                fn($m): array => [
                    $m['memberId'],
                    $m['memberName'],
                    $m['email']
                ],
                $members
            );
            ConsoleUI::table(headers: ['ID', 'Name', 'Email'], rows: $rows);
        }

        ConsoleUI::info(text: "Press Enter to go back...");
        fgets(stream: STDIN);
    }
}

