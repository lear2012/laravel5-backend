<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeyeContact;
use DB;
use Yajra\Datatables\Facades\Datatables;

class KeyeContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.keyecontacts.index');
    }

    public function search() {
        $contacts = DB::table('keye_contacts')
            ->where('contact_type', '=', 1)
            ->whereNull('deleted_at')
            ->select('*');
        return Datatables::of($contacts)
            ->make(true);
    }

    public function contactus()
    {
        //
        return view('backend.keyecontacts.contactus');
    }

    public function searchContact() {
        $contacts = DB::table('keye_contacts')
            ->where('contact_type', '=', 2)
            ->whereNull('deleted_at')
            ->select('*');
        return Datatables::of($contacts)
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
