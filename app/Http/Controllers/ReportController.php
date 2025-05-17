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

    public function store(Request $request, $reportable_id){
        // バリデーション処理
        $validator = Validator::make($request->all(), [
            'reason' => 'required|array|min:1',
            'reason.*' => 'exists:report_reasons,id',
            'reportable_type' => 'required|string|in:App\Models\Post,App\Models\User,App\Models\Answer,App\Models\ChatMessage,App\Models\Comment',
        ]);

        if ($validator->fails()) {
            $prefix = match ($request->input('reportable_type')) {
                'App\Models\Post' => 'reportPostModal-',
                'App\Models\User' => 'reportUserModal-',
                'App\Models\Answer' => 'reportAnswerModal-',
                'App\Models\Comment' => 'reportCommentModal-',
                'App\Models\ChatMessage' => 'reportChatModal-',
                default => 'reportModal-',
            };

            $modalId = $prefix . $reportable_id;

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $modalId); // モーダル再表示用ID
        }

        // Report 登録
        $report          = new Report();
        $report->user_id = Auth::id();
        $report->reportable_type = $request->reportable_type;
        $report->reportable_id = $reportable_id;
        $report->save();

        // チェックされた理由を中間テーブルに登録
        $report_reason_report = collect($request->reason)->map(function ($id) {
            return ['report_reason_id' => $id];
        })->toArray();

        $report->reportReasonReport()->createMany($report_reason_report);

        return redirect()->back();
    }

    public function storeMessage(Request $request, $id){
        // $validator = Validator::make($request->all(), [
        //     'reason' => 'required|array|min:1',
        //     'reason.*' => 'exists:report_reasons,id',
        // ]);

        $report = $this->report->findOrFail($id);

        $report->message = $request->message;
        $report->status = 'warned';
        $report->save();

        return redirect()->back();
    }

    public function close($id){
        $report = $this->report->findOrFail($id);

        $report->status = 'resolved';
        $report->active = false;
        $report->save();

        return redirect()->back();
    }

    public function dismissed($id){
        $report = $this->report->findOrFail($id);

        $report->status = 'dismissed';
        $report->save();

        return redirect()->back();
    }

    public function updateReportMessage(Request $request, $id){
        $report = $this->report->findOrFail($id);

        $report->message = $request->message;
        $report->active = true;
        $report->status = 'warned';
        $report->save();

        return redirect()->back();
    }

    public function deleteReportMessage($id){
        $report = $this->report->findOrFail($id);

        $report->message = null;
        $report->active = true;
        $report->status = 'pending';
        $report->save();

        return redirect()->back();
    }
}
