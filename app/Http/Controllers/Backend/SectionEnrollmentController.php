<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SectionEnrollment;
use Yajra\Datatables\Facades\Datatables;
use DB;

class SectionEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $section_id = $request->get('sid');
        $sectionName = (is_numeric($section_id) && $section_id > 0) ? SectionEnrollment::getSectionNameById($section_id) : 1;
        return view('backend.sectionenrollments.index', [
            'sectionName' => $sectionName
        ]);
    }

    public function cameraIndex(Request $request)
    {
        //
        $section_id = $request->get('sid');
        $sectionName = (is_numeric($section_id) && $section_id > 0) ? SectionEnrollment::getSectionNameById($section_id) : 1;
        return view('backend.sectionenrollments.camera_index', [
            'sectionName' => $sectionName
        ]);
    }

    public function search(Request $request) {
        $section_id = $request->get('sid');
        $section_id = (is_numeric($section_id) && $section_id > 0) ? $section_id : 1;
        $items = DB::table('section_enrollments')
            ->where('section_id', '=', $section_id)
            ->where('reg_type', '=', 1)
            ->select('*');
        return Datatables::of($items)
            ->make(true);
    }

    public function searchCamera(Request $request) {
        $section_id = $request->get('sid');
        $section_id = (is_numeric($section_id) && $section_id > 0) ? $section_id : 1;
        $items = DB::table('section_enrollments')
            ->where('section_id', '=', $section_id)
            ->where('reg_type', '=', 2)
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
        $item = SectionEnrollment::find($id);
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
