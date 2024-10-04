<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModelContractController extends Controller
{
    // Create

    public function store(Request $request){
    //    Tenant::updateOrInsert(['email'=>$request->get('email')],[
    //     'first_name'=>$request->get('first_name'),
    //     'last_name'=>$request->get('last_name'),
    //     'phone'=>$request->get('phone'),
    //     'email'=>$request->get('email'),
    //     'address'=>$request->get('address'),
    //     'bank_account'=>$request->get('bank_account'),
    //     'box_id'=>$request->get('box')
    // ]);
    //     return  redirect()->route('tenant.show',$request->get('owner_id'));
    }

    // Read

    public function show($owner_id){
        // $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        return view('contract.model.list', 
        // ['tenants'=>$boxes]
    );
    }

    // Update

    public function update(Request $request, $id,$owner_id){
    //     Tenant::find($id)->update([   
    //         'first_name'=>$request->get('first_name'),
    //         'last_name'=>$request->get('last_name'),
    //         'phone'=>$request->get('phone'),
    //         'email'=>$request->get('email'),
    //         'address'=>$request->get('address'),
    //         'bank_account'=>$request->get('bank_account'),
    //         'box_id'=>$request->get('box')
    // ]);


    //     return redirect()->route('tenant.show',$owner_id);
    }

    public function edit($id){
        // $tenant=Tenant::find($id);
        // $box=Box::find($tenant->box_id);        
        // $boxes = Box::where('owner_id',$box->owner_id)->with('tenant')->get();
        // return view('tenant.edit', [
        //     'tenant'=>$tenant, 
        //     'tenant_box'=>$box,
        //     'boxes'=>$boxes
        // ]);
    }

    // Delete

    public function destroy(Request $request, $id, $owner_id)
    {
        // Tenant::destroy($id);

        // return redirect()->route('tenant.show',$owner_id);
    }
}
