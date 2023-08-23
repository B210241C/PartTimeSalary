<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Attendance;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;



class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $attendances = DB::table('attendances')
            ->select('attendances.id', 'attendances.timein', 'attendances.timeout', 'attendances.date', 'branches.name as bname')
            ->join('branches', 'attendances.branchid', '=', 'branches.id')
            ->where('attendances.userid', '=', Auth::id())
            ->where('attendances.status', '=', 'pending') // Add this line to filter by status
            ->get();

        return view('attendances.index', ['attendances' => $attendances]);
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

        $diff = Carbon::parse($validatedData['timein'])->diffInMinutes(Carbon::parse($request->input('timeout')));
        $newdiff = date('H:i', mktime(0, intdiv($diff, 30) * 30));

        $attendance = new Attendance;
        $attendance->userid = Auth::id();
        $attendance->timein = $request->input('timein');
        $attendance->timeout = $request->input('timeout');
        $attendance->date = $request->input('date');
        $attendance->status = "pending";
        $attendance->branchid = $request->input('branchid');
        $attendance->duration = $newdiff;

        if ($attendance->save()) {
            // Success: Redirect to a success page or perform other actions
            return redirect()->route('attendances.index'); // Replace with the actual route name
        } else {
            // Error: Redirect back with error message
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create attendance record.']);
        }
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
        try {
            // Validate the request
            $validatedData = $request->validate([
                'timein' => 'required',
                'timeout' => 'required',
                'date' => 'required',
                'branchid' => 'required',
                // Add other validation rules as needed
            ]);

            $diff = Carbon::parse($validatedData['timein'])->diffInMinutes(Carbon::parse($validatedData['timeout']));
            $newdiff = date('H:i', mktime(0, intdiv($diff, 30) * 30));

            $attendance = Attendance::findOrFail($id);
            $attendance->timein = $validatedData['timein'];
            $attendance->timeout = $validatedData['timeout'];
            $attendance->date = $validatedData['date'];
            $attendance->status = "pending";
            $attendance->branchid = $validatedData['branchid'];
            $attendance->duration = $newdiff;
            $attendance->save();

            return redirect()->route('attendances.index')->with('success', 'Attendance record updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating the record.');
        }
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

    public function userVerifiedAttendances($userId)
    {
        $user = User::find($userId);

        $verifiedAttendances = Attendance::where('userid', $userId)
            ->where('status', 'verified')
            ->join('branches', 'attendances.branchid', '=', 'branches.id')
            ->select('attendances.*', 'branches.name as branch_name')
            ->get();

        // Retrieve the user's salary from the database
        $userSalary = $user->salary;

        return view('components.userVerifiedAttendances', compact('user', 'verifiedAttendances', 'userSalary'));
    }

    public function markAsPaid($id)
    {
        $attendance = Attendance::findOrFail($id); // Retrieve the attendance by its ID

        // Update the status to 'paid'
        $attendance->status = 'paid';
        $attendance->save();

        // You can redirect back to the previous page or perform any other action you need
        $users=
            DB::table('attendances')
                ->join('users', 'users.id', '=', 'attendances.userid')
                ->select(
                    'attendances.userid',
                    DB::raw('COUNT(*) AS count'),
                    'users.id AS uid',
                    'users.name AS uname',
                    DB::raw('SUM(attendances.duration) AS total_duration'),
                    'users.salary',
                    'users.pnumber',
                    'users.email'
                )
                ->groupBy('attendances.userid', 'users.id', 'users.name', 'users.salary', 'users.pnumber', 'users.email')
                ->where('attendances.status', '=', 'verified')
                ->get();
        return view('components.checkoutlist', ['users'=>$users]);
    }

    public function unpaid()
    {
        $attendances = DB::table('attendances')
            ->select('attendances.id', 'attendances.timein', 'attendances.timeout', 'attendances.date', 'branches.name as bname')
            ->join('branches', 'attendances.branchid', '=', 'branches.id')
            ->where('attendances.userid', '=', Auth::id())
            ->where('attendances.status', '=', 'verified') // Add this line to filter by status
            ->get();

        return view('attendances.unpaid', ['attendances' => $attendances]);
    }


}
