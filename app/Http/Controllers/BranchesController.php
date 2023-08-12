<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Http\Requests\BranchRequest;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $branches= Branch::all();
        return view('branches.index', ['branches'=>$branches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BranchRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BranchRequest $request)
    {
        $branch = new Branch;
		$branch->name = $request->input('name');
        $branch->save();

        return to_route('branches.index');
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
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id,$timein)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.edit',['branch'=>$branch,$timein]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BranchRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BranchRequest $request, $id)
    {
        $branch = Branch::findOrFail($id);
		$branch->name = $request->input('name');
        $branch->save();

        return to_route('branches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return to_route('branches.index');
    }
}
