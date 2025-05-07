<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReportReasonReport;

class ReportReason extends Model
{
    protected $fillable = ['name'];

    public function reportReasonReport(){
        return $this->hasMany(ReportReasonReport::class);
    }
}
