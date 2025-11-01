<?php
namespace Core\Repositories;

use Core\Models\Member;

class MemberRepository {
   
    private static $file = __DIR__ . '/../data/members.json';

    public static function findAll(): mixed {
        return DataStore::read(path: self::$file);
    }

    public static function add($member): void {
        $members = self::findAll();
        $members[] = $member;
        DataStore::write(path: self::$file, data: $members);
    }

    public static function findById($id): mixed {
        $members = self::findAll();
        foreach ($members as $member) {
            if ($member['memberId'] == $id) {
                return $member;
            }
        }
        return null;
    }
}

