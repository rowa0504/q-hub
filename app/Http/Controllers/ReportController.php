<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    private $report;

    public function __construct(Report $report){
        $this->report = $report;
    }

    public function store(Request $request, $post_id)
{
    $modalId = 'reportModal-' . $post_id;

    // バリデーション処理
    $validator = Validator::make($request->all(), [
        'reason' => 'required|array|min:1',
        'reason.*' => 'exists:report_reasons,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('open_modal', $modalId); // モーダル再表示用ID
    }

    // Report 登録
    $report = new Report();
    $report->user_id = Auth::id();
    $report->post_id = $post_id;
    $report->save();

    // チェックされた理由を中間テーブルに登録
    $report_reason_report = collect($request->reason)->map(function ($id) {
        return ['report_reason_id' => $id];
    })->toArray();

    $report->reportReasonReport()->createMany($report_reason_report);

    return redirect()->back()->with('success', '報告を受け付けました。');
}
}
