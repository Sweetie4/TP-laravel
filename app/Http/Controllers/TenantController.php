<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{


    /**
     * Create a new tenant
     * @param Request $request new tenant's data
     */
    public function store(Request $request){
    Tenant::updateOrInsert(['email'=>$request->get('email')],[
        'first_name'=>$request->get('first_name'),
        'last_name'=>$request->get('last_name'),
        'phone'=>$request->get('phone'),
        'email'=>$request->get('email'),
        'address'=>$request->get('address'),
        'bank_account'=>$request->get('bank_account'),
        'user_id'=>$request->get('owner_id')
    ]);

        Box::where('id',$request->get('box'))->update(['tenant_id'=>Tenant::where('email',$request->get('email'))->first()->id]);
        return  redirect()->route('tenant.show',$request->get('owner_id'));
    }

    /**
     * List all tenants
     * @param int $owner_id authenticad user's id
     */
    public function show($owner_id){
        $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        return view('tenant.list', ['tenants'=>$boxes]);
    }

    /**
     * Update a tenant
     * @param Request $request updated data for tenant
     * @param int $id tenant's id
     * @param int $owner_id authenticated user's id
     */
    public function update(Request $request, $id,$owner_id){
        Tenant::find($id)->update([   
            'first_name'=>$request->get('first_name'),
            'last_name'=>$request->get('last_name'),
            'phone'=>$request->get('phone'),
            'email'=>$request->get('email'),
            'address'=>$request->get('address'),
            'bank_account'=>$request->get('bank_account'),
            'box_id'=>$request->get('box')
    ]);
        return redirect()->route('tenant.show',$owner_id);
    }

    /**
     * Show form to edit a tenant
     * @param int $id tenant's id
     */
    public function edit($id){
        $tenant=Tenant::find($id);
        $box=Box::find($tenant->box_id);        
        $boxes = Box::where('owner_id',$box->owner_id)->with('tenant')->get();
        return view('tenant.edit', [
            'tenant'=>$tenant, 
            'tenant_box'=>$box,
            'boxes'=>$boxes
        ]);
    }

    /**
     * delete a tenant
     * @param Request $request
     * @param int $id deleted tenant's id
     * @param int $owner_id authenticated user's id
     */
    public function destroy(Request $request, $id, $owner_id)
    {
        Tenant::destroy($id);

        return redirect()->route('tenant.show',$owner_id);
    }

    /**
     * Export all tenant's to csv
     * 
     */
    public function export(){
        $filename = "locataires_".date('Y-m-d').".csv";
        $tenant_file = fopen("php://output", "w");
        $content = "Nom;Prénom;Email;Téléphone;Adresse;\n";
        $tenants = Tenant::where('user_id', Auth::user()->id)->get();
        foreach ($tenants as $tenant){
            $content .= $tenant->last_name.";".$tenant->first_name.";".$tenant->email.";".$tenant->phone.";".str_replace("\n",'',$tenant->address).";\n";
        }
        fwrite($tenant_file, $content);
        fclose($tenant_file);
        $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
    }
}
