<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChetieApply;
use DB;
use Yajra\Datatables\Facades\Datatables;

class CheTieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.chetie.index');
    }

    public function search() {
        $items = DB::table('chetie_applys')
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
        $item = ChetieApply::find($id);
        if(!$item) {
            self::setMsgCode(9003);
        }
        $item->status = $val;
        if(!$item->save()) {
            self::setMsgCode(1016);
        }
        self::sendJsonMsg();
    }
}
