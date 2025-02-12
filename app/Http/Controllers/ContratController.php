<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\ModelContract;
use App\Models\Tenant;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $model = ModelContract::where('id',$request->model)->first();
        $exploded_model = explode("#", $model->content);
        $reconstructed_model = '';
        foreach($exploded_model as $text) {
            if(str_contains($text,'.')) {
                $parts = explode('.',$text);
                if ($parts[0] === 'user'){
                    $user = User::where('id', $request->owner_id)->first();
                    $text = $user[$parts[1]];
                } else if ($parts[0]==='tenant'){
                    $tenant = Tenant::where('id', $request->tenant)->first();
                    $text = $tenant[$parts[1]];
                } else if ($parts[0]==='box'){
                    $box = Box::where('id', $request->box)->first();
                    $text = $box[$parts[1]];
                }
            }
            if (str_contains($text,"\n")){
                $text =str_replace("\n", "<br>", $text);
            }
            $reconstructed_model .= $text;
        }
        $data =['text'=>$reconstructed_model, 'title'=>$model->name];
        $pdf = Pdf::loadView('contract.pdf.contract', $data);
        $title = str_replace(" ", "_", $model->name);
        return $pdf->download($title."_".$tenant->first_name."_".$tenant->last_name."_".$box->id."_".date('Y-m-d').".pdf");

        return view('dashboard');
    }
}
