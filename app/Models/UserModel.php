<?php

namespace App\Models;

class UserModel extends BaseModel {

    protected $table = 'users';

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    public function getDefaultPassword() {
        return 'PictureWorks';
    }

}
