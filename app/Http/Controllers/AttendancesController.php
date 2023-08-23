<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Attendance;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $attendances= DB::table('attendances')
            ->select('attendances.id','attendances.timein', 'attendances.timeout', 'attendances.date', 'attendances.status', 'attendances.duration','branches.name as bname')
            ->join('branches','attendances.branchid','=','branches.id')
            ->where('attendances.userid', '=', Auth::id())
            ->get();
        return view('attendances.index', ['attendances'=>$attendances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $branches= Branch::all();
        return view('attendances.create',['data'=>$branches]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AttendanceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AttendanceRequest $request)
    {
        $validatedData = $request->validate([
            'timein' => 'required',
            'timeout' => 'required|after:timein',
            'branchid' => 'required',
            'date' => 'required',
        ]);

        $diff=Carbon::parse($validatedData['timein'])->diffInMinutes(Carbon::parse($request->input('timeout')));
        $newdiff=date('H:i',mktime(0,intdiv($diff,30)*30));



        $attendance = new Attendance;
        $attendance->userid = Auth::id();
        $attendance->timein = $request->input('timein');
        $attendance->timeout = $request->input('timeout');
        $attendance->date = $request->input('date');
        $attendance->status = "pending";
        $attendance->branchid = $request->input('branchid');
        $attendance->duration = $newdiff;
        $attendance->save();

        return to_route('attendances.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $branches= Branch::all();
        $data= Attendance::findOrFail($id);
        return view('attendances.edit',['data'=>$branches,'datas'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AttendanceRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AttendanceRequest $request, $id)

    {
        $diff=Carbon::parse($request->input('timein'))->diffInMinutes(Carbon::parse($request->input('timeout')));
        $newdiff=date('H:i',mktime(0,intdiv($diff,30)*30));

        $attendance = Attendance::findOrFail($id);
        $attendance->timein = $request->input('timein');
        $attendance->timeout = $request->input('timeout');
        $attendance->date = $request->input('date');
        $attendance->status = "pending";
        $attendance->branchid = $request->input('branchid');
        $attendance->duration = $newdiff;
        $attendance->save();

        return to_route('attendances.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return to_route('attendances.index');
    }

    public function pendingApprove()
    {
        $attendances= DB::table('attendances')
            ->select('attendances.id', 'branches.name as bname', 'users.name as uname', 'attendances.timein', 'attendances.timeout', 'attendances.date', 'attendances.status', 'attendances.duration')
            ->join('users','attendances.userid','=','users.id')
            ->join('branches','attendances.branchid','=','branches.id')
            ->where('attendances.status', '=', 'pending')
            ->get();
        return view('components.admin_approve_attendance', ['attendances'=>$attendances]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->status = "verified";
        $attendance->save();
        return to_route('pendingApprove');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $year = $request->input('year');
        $month = $request->input('month');

        $query = DB::table('attendances')
            ->select('attendances.id', 'branches.name as bname', 'users.name as uname', 'attendances.timein', 'attendances.timeout', 'attendances.date', 'attendances.status', 'attendances.duration')
            ->join('users', 'attendances.userid', '=', 'users.id')
            ->join('branches', 'attendances.branchid', '=', 'branches.id')
            ->where('attendances.status', '=', 'pending');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('branches.name', 'like', '%' . $search . '%');
            });
        }

        if ($year) {
            $query->whereYear('attendances.date', $year);
        }

        if ($month) {
            $query->whereMonth('attendances.date', $month);
        }

        $attendances = $query->get();

        return view('components.admin_approve_attendance', ['attendances' => $attendances]);
    }



}
