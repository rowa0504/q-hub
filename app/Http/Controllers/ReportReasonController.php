<?php

namespace App\Http\Controllers;
use App\Models\ReportReason;
use Illuminate\Http\Request;

class ReportReasonController extends Controller
{
    private $reportReason;

    public function __construct(ReportReason $reportReason){
        $this->reportReason = $reportReason;
    }

    public function create(){
        $all_reportReasons = $this->reportReason->paginate(10);

        return view('admin.reports.reportReason-index', compact('all_reportReasons'));
    }

    public function store(Request $request){
        $request->validate([
            'reportReason'    => 'required|min:1|max:50|unique:report_reasons,name'
        ]);

        $this->reportReason->name = $request->reportReason;
        $this->reportReason->save();

        return redirect()->back();
    }

    public function update(Request $request,$id){
        $request->validate([
            'reportReason'    => 'required|min:1|max:50|unique:report_reasons,name'
        ]);

        $reportReason = $this->reportReason->findOrFail($id);
        $reportReason->name = $request->reportReason;
        $reportReason->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->reportReason->destroy($id);

        return redirect()->back();
    }
}


