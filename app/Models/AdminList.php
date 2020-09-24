<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminList extends Model {

    protected $table = 'admin_list';
    protected $fillable = ['chat_id', 'area_number'];

}