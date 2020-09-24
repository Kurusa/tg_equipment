<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model {

    protected $table = 'equipment';
    protected $fillable = ['admin_user_id', 'worker_user_id', 'type_id', 'title', 'status'];

}