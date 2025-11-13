<?php
namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use Core\Models\Member;

class MemberTest extends TestCase
{
    public function testMemberCanBeCreated(): void
    {
        $member = new Member(
            id: 1,
            name: 'John Doe',
            email: 'john@example.com',
            phone: '0412345678',
            date: '2025-11-01'
        );

        $this->assertEquals(expected: 1, actual: $member->memberId);
        $this->assertEquals(expected: 'John Doe', actual: $member->memberName);
        $this->assertEquals(expected: 'john@example.com', actual: $member->email);
        $this->assertEquals(expected: '0412345678', actual: $member->phone);
        $this->assertEquals(expected: '2025-11-01', actual: $member->membershipDate);
    }

    public function testMemberHasValidEmail(): void
    {
        $member = new Member(
            id: 1,
            name: 'Test User',
            email: 'test@test.com',
            phone: '0400000000',
            date: '2025-11-01'
        );

        $this->assertStringContainsString(needle: '@', haystack: $member->email);
    }
}

