<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function reportReason(){
        return $this->belongsTo(ReportReason::class);
    }
}
