<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    // Create

    public function store(Request $request){
       Tenant::insert([
        'first_name'=>$request->get('first_name'),
        'last_name'=>$request->get('last_name'),
        'phone'=>$request->get('phone'),
        'email'=>$request->get('email'),
        'address'=>$request->get('address'),
        'bank_account'=>$request->get('bank_account'),
        'box_id'=>$request->get('box')
    ]);
        return  redirect()->route('tenant.show',$request->get('owner_id'));
    }

    // Read

    public function show($owner_id){
        $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        return view('tenant.list', ['tenants'=>$boxes]);
    }

    // Update

    public function update($owner_id){
        // $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        // return view('tenant.list', ['tenants'=>$boxes]);
    }

    public function edit($owner_id){
        // $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        // return view('tenant.list', ['tenants'=>$boxes]);
    }

    // Delete

    public function destroy($owner_id){
        // $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        // return view('tenant.list', ['tenants'=>$boxes]);
    }
}
