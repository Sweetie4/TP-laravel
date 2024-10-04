<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\ModelContract;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    // Create

    public function create($type, $id,$logged_id){
        $boxes = Box::where('owner_id',$logged_id)->with('tenant')->get();
        $models = ModelContract::where('landlord_id',$logged_id)->get();
        if($type=="box"){
            $box=Box::where('id',$id)->with('tenant')->first();
            if ($box->tenant){
                return view('contract.generate',['box'=>$box, 'tenant'=>$box->tenant,'model'=>$models]); 
            } else {
                return view('contract.generate',['box'=>$box, 'tenant'=>$boxes,'model'=>$models]); 
            }
        } else if($type=="tenant"){
            $tenant = Tenant::where('id',$id)->first();
            $box = Box::where('id',$tenant->box_id)->first();
            return view('contract.generate',['box'=>$box, 'tenant'=>$tenant,'model'=>$models]); 
        }else if($type=="contract"){
            $model = ModelContract::find($id);
            return view('contract.generate',['box'=>$boxes, 'tenant'=>$boxes,'model'=>$model]); 
        }else {
            dd('error');
        }
    }

    public function store(Request $request ){
        $model = ModelContract::where('id',$request->get('model'))->first();
        $exploded_model = explode("#", $model->content);
        foreach($array as $key => $value) {
            if($key%2 == 0) 
            continue;
        }
        dd('fifsh');
        return view('dashboard');
    }
}
