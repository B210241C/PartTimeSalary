<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Attendance;
use App\Http\Requests\AttendanceRequest;
use Illuminate\Support\Facades\Auth;
class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $attendances= Attendance::all();
        return view('attendances.index', ['attendances'=>$attendances]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AttendanceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AttendanceRequest $request)
    {
        $attendance = new Attendance;
		$attendance->userid = Auth::id();
		$attendance->timein = $request->input('timein');
		$attendance->timeout = $request->input('timeout');
		$attendance->date = $request->input('date');
        $attendance->save();

        return to_route('attendances.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendances.show',['attendance'=>$attendance]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendances.edit',['attendance'=>$attendance]);
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
        $attendance = Attendance::findOrFail($id);
		$attendance->userid = $request->input('userid');
		$attendance->timein = $request->input('timein');
		$attendance->timeout = $request->input('timeout');
		$attendance->date = $request->input('date');
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
}
