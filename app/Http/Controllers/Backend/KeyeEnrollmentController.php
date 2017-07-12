<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KeyeEnrollment;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Facades\Datatables;

class KeyeEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.keyeenrollments.index');
    }

    public function search() {
        $items = DB::table('keye_enrollments')
            ->select('*');
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

    public function active(Request $request)
    {
        //
        $id = (int)$request->get('id');
        $val = (int)$request->get('val');
        if(!is_numeric($id) || ($val != 0 && $val != 1)) {
            self::setMsgCode(9001);
        }
        $route = KeyeEnrollment::find($id);
        if(!$route) {
            self::setMsgCode(9003);
        }
        $route->status = $val;
        if(!$route->save()) {
            self::setMsgCode(1016);
        }
        self::sendJsonMsg();
    }
}
