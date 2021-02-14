<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Mail;
use App\Mail\ReportReply;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Report::select('*');
            return datatables()->of($data)
                ->addColumn('actions', function ($row) {
                    return '<a class="btn btn-primary" href="'.route('admin.reports.show', $row->id).'">Reply</a>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "0")
                        return "Waiting for reply";
                    else
                        return "Replied";
                })
                ->rawColumns(['actions', 'status'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.reports.index');
    }

    public function show($id)
    {
        $report = Report::find($id);
        return view('admin.reports.reply', compact('report'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $report = Report::find($id);
        $report->status = 1;
        $report->update();
        $data = [
            'name' => $report->user->name,
            'surname' => $report->user->surname,
            'body' => $request->body,
        ];
        \Mail::to($report->user->email)->send(new ReportReply($data));
        return redirect()->route('admin.reports.index')->with('success', 'Reply sent');
    }
}
