<?php
namespace Core\Models;

class Author {
    public $authorId;
    public $authorName;
    public $nationality;
    public $biography;

    public function __construct($authorId, $authorName, $nationality, $biography) {
        $this->authorId = $authorId;
        $this->authorName = $authorName;
        $this->nationality = $nationality;
        $this->biography = $biography;
    }
}

