<?php 
namespace Core\Models;

class Book extends LibraryResource { 
  public $name;
  public $isbn;
  public $publisher;
  public $year;
  public $author;

  public function __construct($id, $addedDate, $name, $isbn, $publisher, $year, $author) {
    parent::__construct(resourceId: $id, resourceCategory: "Book", addedDate: $addedDate);
    $this->name = $name;
    $this->isbn = $isbn;
    $this->publisher = $publisher;
    $this->year = $year;
    $this->author = $author;
  }
}
