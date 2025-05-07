<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportReasonReport extends Model
{
    protected $table = 'report_reason_report';

    protected $fillable = ['reason_id', 'report_reason_id'];

    public $timestamps = false;

    public function reportReason(){
        return $this->belongsTo(ReportReason::class);
    }

    public function reason(){
        return $this->belongsTo(ReportReason::class, 'report_reason_id');
    }

    public function report(){
        return $this->belongsTo(Report::class);
    }
}
