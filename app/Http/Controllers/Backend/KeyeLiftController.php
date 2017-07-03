<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Facades\Datatables;

class KeyeLiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.keyelifts.index');
    }

    public function search() {
        $items = DB::table('keye_lifts as kl')
            ->leftJoin('keye_enrollments as ke', 'ke.id', '=', 'kl.enrollment_id')
            ->selectRaw('kl.id, kl.name, kl.mobile, kl.wechat_no, kl.created_at, 
            ke.name as ke_name, ke.mobile as ke_mobile, ke.start, ke.end, ke.wechat_no as ke_wechat,
            ke.brand, ke.series, ke.year
            ')
            ->orderBy('kl.id', 'desc');
        return Datatables::of($items)
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
