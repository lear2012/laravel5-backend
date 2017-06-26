<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use App\Models\KeyeRoute;
use Yajra\Datatables\Facades\Datatables;
use DB;
use App\Http\Requests\Backend\RouteCreateRequest;

class KeyeRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('backend.keyeroutes.index');
    }

    public function search() {
        $routes = DB::table('keye_routes')->select('*');
        return Datatables::of($routes)
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
        return view('backend.keyeroutes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RouteCreateRequest $request)
    {
        //
        //var_dump($request->all());exit;
        $route = new KeyeRoute();
        $data = $request->all();
        $route->fill($request->all());
        if(!isset($data['is_front']))
            $route->is_front = 0;
        if(!isset($data['active']))
            $route->active = 0;
        $url = route('admin.keyeroutes.index');
        if($route->save()) {
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.create_keyeroute_success'), 'success'));
        } else
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.create_keyeroute_fail'), 'error'));
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
        $route = KeyeRoute::find($id);
        if(!$route) {
            self::setMsgCode(9003);
        }
        return view('backend.keyeroutes.edit', [
            'route' => $route
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RouteCreateRequest $request, $id)
    {
        //
        if(!is_numeric($id)) {
            self::setMsgCode(9001);
        }
        $route = KeyeRoute::find($id);
        if(!$route) {
            self::setMsgCode(9003);
        }
        $data = $request->all();
        $route = $route->fill($data);
        if(!isset($data['is_front']))
            $route->is_front = 0;
        if(!isset($data['active']))
            $route->active = 0;
        $url = route('admin.keyeroutes.index');
        if($route->save()) {
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.update_keyeroute_success'), 'success'));
        } else
            return redirect()->to($url)->with('jsmsg', amaran_msg(trans('message.update_keyeroute_fail'), 'error'));
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
        $route = KeyeRoute::find($id);
        if(!$route) {
            self::setMsgCode(9003);
        }
        $route->active = $val;
        if(!$route->save()) {
            self::setMsgCode(1016);
        }
        self::sendJsonMsg();
    }
}
