<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function reportReasonReport(){
        return $this->hasMany(reportReasonReport::class);
    }
}
