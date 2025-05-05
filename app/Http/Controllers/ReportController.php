<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    private $report;

    public function __construct(Report $report){
        $this->report = $report;
    }

    public function store(Request $request, $post_id)
    {
        // $request->vaildate([
        //     'reason'  => 'rquired',
        // ]);

        $this->report->user_id    = Auth::user()->id;
        $this->report->post_id = $post_id;
        $this->report->save();
        
        foreach($request->reason as $report_reason_id)
    {
        $report_reason_report[] = ['report_reason_id' => $report_reason_id]; 
    }

    $this->report->reportReasonReport()->createMany($report_reason_report);

    return redirect()->back();

    }
}
