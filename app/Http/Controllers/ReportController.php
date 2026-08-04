<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportJob;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $report = Report::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'status' => 'pending'
        ]);

        // ✅ Dispatch Job
        GenerateReportJob::dispatch($report);

        return response()->json([
            'success' => true,
            'message' => 'Report generation started!',
            'data' => $report
        ]);
    }

    public function status($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    public function download($id)
    {
        $report = Report::find($id);

        if (!$report || $report->status !== 'completed') {
            return response()->json(['success' => false, 'message' => 'Report not ready'], 404);
        }

        return response()->download(storage_path('app/public/' . $report->file_path));
    }
}
