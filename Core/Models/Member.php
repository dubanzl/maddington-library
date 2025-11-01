<?php

namespace Core\Models;

class Member {
    public $memberId;
    public $memberName;
    public $email;
    public $phone;
    public $membershipDate;
    public $borrowedResources = [];

    public function __construct($id, $name, $email, $phone, $date) {
        $this->memberId = $id;
        $this->memberName = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->membershipDate = $date;
    }
}

