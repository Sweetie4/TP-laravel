<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Tenant;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function show($owner_id){
        return view('box.box', ['boxes'=>Box::where('owner_id',$owner_id)->with('tenant')->get()]);
    }

    public function edit($id){
        return view('box.edit', ['box'=>Box::find($id), 'boxes'=>Box::where('owner_id', Box::find($id)->owner_id)->with('tenant')->get()]);
    }

    public function store(Request $request)
    {
        Box::insert([ 'owner_id'=> $request->get('owner_id'),'price'=> $request->get('price'), 'address'=>$request->get('address'), 'img_url'=>$request->get('img_url')]);
        return redirect()->route('box.show',$request->get('owner_id'));
    }

    public function destroy(Request $request, $id, $owner_id)
    {
        Box::destroy($id);

        return redirect()->route('box.show',$owner_id);
    }
    public function update(Request $request, $id, $owner_id)
    {
        Box::find($id)->update(['price'=> $request->get('price'), 'address'=>$request->get('address'), 'img_url'=>$request->get('img_url')]);
        if ($request->get('tenant_id')){
            Tenant::find($request->get('tenant_id'))->update(['box_id'=>$id]);
        }

        return redirect()->route('box.show',$owner_id);
    }
}
