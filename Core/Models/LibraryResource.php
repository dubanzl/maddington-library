<?php 

namespace Core\Models;


Class LibraryResource {
   public $resourceId;
   public $resourceCategory;
   public $addedDate;
   public $availability;

   public function __construct($resourceId, $resourceCategory, $addedDate, $availability = true) {
      $this->resourceId = $resourceId;
      $this->resourceCategory = $resourceCategory;
      $this->addedDate = $addedDate;
      $this->availability = $availability;
   }

    public function markAsBorrowed(): void {
        $this->availability = false;
    }

    public function markAsReturned(): void {
        $this->availability = true;
    }
}
