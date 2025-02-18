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

    /**
     * Show form to create a contract
     * @param string $type where do the generate demand comes from
     * @param int $id id corresponding to the type (tenant, box, contract_model)
     * @param int $logged_id authenticad user's id
     */
    public function create($type, $id,$logged_id){
        $boxes = Box::where('owner_id',$logged_id)->with('tenant')->get();
        $models = ModelContract::where('landlord_id',$logged_id)->get();

        // If generate contract demand came from the boxes' page
        if($type=="box"){
            $box=Box::where('id',$id)->with('tenant')->first();
            if ($box->tenant){
                return view('contract.generate',['box'=>$box, 'tenant'=>$box->tenant,'model'=>$models]); 
            } else {
                return view('contract.generate',['box'=>$box, 'tenant'=>$boxes,'model'=>$models]); 
            }
            
        // If generate contract demand came from the tenants' page
        } else if($type=="tenant"){
            $tenant = Tenant::where('id',$id)->with('box')->first();
            $box = $tenant->box;
            return view('contract.generate',['box'=>$box, 'tenant'=>$tenant,'model'=>$models]); 
            
        // If generate contract demand came from the contract models' page
        }else if($type=="contract"){
            $model = ModelContract::find($id);
            return view('contract.generate',['box'=>$boxes, 'tenant'=>$boxes,'model'=>$model]); 
        }else {
            dd('error');
        }
    }

    /**
     * Create a new contract
     * @param Request $request data for the new contract
     */
    public function store(Request $request ){
        $model = ModelContract::where('id',$request->model)->first();
        $exploded_model = explode('#',ModelContractController::jsonToHtml($model));
        $reconstructed_model = '';
        $box = Box::where('id', $request->box)->first();
        if ($box->tenant_id != $request->tenant){
            $box->update(['tenant_id' => $request->tenant]);
        }

        // discriminate between text to change and not in model contract
        foreach($exploded_model as $text) {
            if(str_contains($text,'.')) {
                $parts = explode('.',$text);
                if ($parts[0] === 'user'){
                    $user = User::where('id', $request->owner_id)->first();
                    $text = $user[$parts[1]];
                } else if ($parts[0]==='tenant'){
                    $tenant = Tenant::where('id', $request->tenant)->first();
                    if ($parts[1]=="name"){
                        $text = $tenant->first_name." ".$tenant->last_name;
                    } else {
                        $text = $tenant[$parts[1]];
                    }
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
                        $text = $request->price;
                    } else if ($parts[1]==='total'){
                        $text= $request->price*$interval;
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
        $file_name = $title."_".$tenant->first_name."_".$tenant->last_name."_".$box->name."_".date('Y-m-d').".pdf";
        $content = $pdf->download()->getOriginalContent();
        Storage::disk('public')->put($file_name, $content);
        Contract::insertGetId([
            'name'=>$file_name,
            'owner_id'=>$user->id,
            'tenant_id'=>$tenant->id,
            'box_id'=>$box->id,
            'model_id'=>$model->id,
            'monthly_price'=>$request->price,
            'start_date'=>date_create($request->start_date),
            'end_date'=>date_create($request->end_date),
            'file_path'=>Storage::url($file_name),
        ]);
        return $pdf->download($file_name);
    }

    /**
     * Show all contracts
     * @param int $owner_id authenticated user's id
     */
    public function show($owner_id){
        $contracts = Contract::where('owner_id',$owner_id)->with('tenant','box', 'model')->get();
        return view('contract.list', 
            ['contracts'=>$contracts, 'owner_id'=>$owner_id]
        );
    }
    
    /**
     * Delete a contract
     * @param Request $request 
     * @param int $id deleted contract's id
     * @param int $owner_id authenticated_user's id
     */
    public function destroy(Request $request, $id, $owner_id){
        Contract::destroy($id);
        return redirect()->route('contracts.show',$owner_id);
    }
    
    /**
     * Download a contract
     * @param string $file_name filename of the contract downloaded
     */
    public function download($file_name){
        return Storage::disk('public')->download($file_name);
    }
}
