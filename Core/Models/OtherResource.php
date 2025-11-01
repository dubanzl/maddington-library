<?php

namespace Core\Models;

Class OtherResource extends LibraryResource {
    public $id;
    public $res_des;
    public $res_brand;

    public function __construct($id, $res_des, $res_brand, $addedDate ){
        parent::__construct(resourceId: $id, resourceCategory: $res_des, addedDate: $addedDate);
        $this->id = $id;
        $this->res_des = $res_des;
        $this->res_brand = $res_brand;
    }
}