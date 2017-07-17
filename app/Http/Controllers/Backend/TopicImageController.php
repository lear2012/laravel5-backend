<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Facades\Datatables;
use App\Models\TopicImage;

class TopicImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.topicimage.index');
    }

    public function search() {
        $items = DB::table('topic_images')
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
        return view('backend.topicimage.create');
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
        $item = new TopicImage();
        $data = $request->all();
        $item->fill($request->all());
        if(!isset($data['active']))
            $item->active = 0;
        $url = route('admin.topicimage.index');
        if($item->save()) {
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.create_topicimage_success'), 'success'));
        } else
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.create_topicimage_fail'), 'error'));
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
        if(!is_numeric($id)) {
            self::setMsgCode(9001);
        }
        $item = TopicImage::find($id);
        if(!$item) {
            self::setMsgCode(9003);
        }
        return view('backend.topicimage.edit', [
            'item' => $item
        ]);
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
        if(!is_numeric($id)) {
            self::setMsgCode(9001);
        }
        $item = TopicImage::find($id);
        if(!$item) {
            self::setMsgCode(9003);
        }
        $data = $request->all();
        $item = $item->fill($data);
        if(!isset($data['active']))
            $item->active = 0;
        $url = route('admin.topicimage.index');
        if($item->save()) {
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.update_topicimage_success'), 'success'));
        } else
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.update_topicimage_fail'), 'error'));
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
        $item = TopicImage::find($id);
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
