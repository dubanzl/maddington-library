<?php
namespace Core\Models;

class BorrowTransaction {
    public $transactionId;
    public $memberId;
    public $resourceId;
    public $borrowDate;
    public $dueDate;
    public $returnDate;

    public function __construct($transactionId, $memberId, $resourceId, $borrowDate, $dueDate, $returnDate = null) {
        $this->transactionId = $transactionId;
        $this->memberId = $memberId;
        $this->resourceId = $resourceId;
        $this->borrowDate = $borrowDate;
        $this->dueDate = $dueDate;
        $this->returnDate = $returnDate;
    }

    public function markAsReturned(): void {
        $this->returnDate = date(format: 'Y-m-d');
    }
}
