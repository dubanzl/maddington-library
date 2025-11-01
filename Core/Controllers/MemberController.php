<?php
namespace Core\Controllers;

use Core\Models\Member;
use Core\Repositories\MemberRepository;

class MemberController {
    public static function addMember($name, $email, $phone): void {
        $members = MemberRepository::findAll();
        $member = new Member(id: count(value: $members) + 1, name: $name, email: $email, phone: $phone, date: date(format: 'Y-m-d'));
        MemberRepository::add(member: $member);
        echo "Member '{$member->memberName}' added.\n";
    }

    public static function listMembers(): mixed {
        $members = MemberRepository::findAll();
        if (empty($members)) {
            echo "No members found.\n";
            return [];
        }
       return $members;
    }
}

