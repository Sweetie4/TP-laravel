<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Contract;
use App\Models\ModelContract;
use App\Models\Tenant;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $tenant = Tenant::where('id',$id)->with('box')->first();
            $box = $tenant->box;
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
        $box = Box::where('id', $request->box)->first();
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
                    $text = $box[$parts[1]];
                } else if ($parts[0]==='date'){
                    if ($parts[1]==='start'){
                        $text = $request->start_date;
                    } else if ($parts[1]==='end') {
                        $text = $request->end_date;
                    }
                } else if ($parts[0]==='price'){
                    $start_date = date_create($request->start_date);
                    $end_date = date_create($request->end_date);
                    $interval = date_diff($start_date, $end_date);
                    $interval = $interval->format('%y') * 12 + $interval->format('%m') +($interval->format('%d')>0?1:0) ;
                    if ($parts[1]==='month') {
                        $text = $box->price;
                    } else if ($parts[1]==='total'){
                        $text= $box->price*$interval;
                    }
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
        $file_name = $title."_".$tenant->first_name."_".$tenant->last_name."_".$box->id."_".date('Y-m-d').".pdf";
        $content = $pdf->download()->getOriginalContent();
        Storage::disk('public')->put($file_name, $content);
        $contract = Contract::insertGetId([
            'name'=>$file_name,
            'owner_id'=>$user->id,
            'tenant_id'=>$tenant->id,
            'box_id'=>$box->id,
            'model_id'=>$model->id,
            'monthly_price'=>$box->price,
            'start_date'=>date_create($request->start_date),
            'end_date'=>date_create($request->end_date),
            'file_path'=>Storage::url($file_name),
        ]);
        PaymentController::store($contract);
        return $pdf->download($file_name);
    }

    public function show($owner_id){
        $contracts = Contract::where('owner_id',$owner_id)->with('tenant','box', 'model')->get();
        return view('contract.list', 
            ['contracts'=>$contracts, 'owner_id'=>$owner_id]
        );
    }

        // Delete

        public function destroy(Request $request, $id, $owner_id)
        {
            Contract::destroy($id);
    
            return redirect()->route('contracts.show',$owner_id);
        }
    
    public function download($file_name){
        return Storage::disk('public')->download($file_name);
    }
}
