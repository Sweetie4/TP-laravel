<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function show($owner_id){
        $boxes = Box::where('owner_id',$owner_id)->with('tenant')->get();
        return view('tenant.list', ['tenants'=>$boxes]);
    }
}
