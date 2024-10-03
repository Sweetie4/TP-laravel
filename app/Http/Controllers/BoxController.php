<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function show($id){
        return view('box', ['boxes'=>Box::where('owner_id',$id)->get()]);
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
}
