<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users= DB::table('users')
            ->select('users.id','users.pnumber','users.salary','users.role','users.name')
            ->where('users.role', '=', 'user')
            ->get();
        return view('users.index', ['users'=>$users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->salary = $request->input('salary');
        $user->role = $request->input('role');
        $user->pnumber = $request->input('pnumber');
        $user->save();

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return to_route('users.index');
    }
    public function adminIndex()
    {
        $users= DB::table('users')
            ->select('users.id','users.pnumber','users.name')
            ->where('users.role', '=', 'admin')
            ->get();
        return view('components.adminindex', ['users'=>$users]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeToUser($id)
    {
        $attendance = User::findOrFail($id);
        $attendance->role = "user";
        $attendance->save();
        return to_route('adminIndex');
    }
    public function checkoutlist()
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout($uid)
    {
        Attendance::where('userid', $uid)
            ->where('status', 'verified')
            ->update(['status' => 'paid']);
        return to_route('checkoutlist');

    }
}
