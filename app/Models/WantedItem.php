<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WantedItem extends Model
{
    protected $fillable = ['user_id', 'keyword'];
}
