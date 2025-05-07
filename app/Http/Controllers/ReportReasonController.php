<?php

namespace App\Http\Controllers;
use App\Models\ReportReason;
use Illuminate\Http\Request;

class ReportReasonController extends Controller
{
    private $reportReason;

    public function __construct(ReportReason $reportReason)
    {
        $this->reportReason = $reportReason;
    }
}


