<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelContract;
use Illuminate\Http\Request;

class ModelContractController extends Controller
{
    // Create

    public function store(Request $request){
        ModelContract::insert([
            'name'=>$request->get('name'),
            'content'=>$request->get('content'),
            'landlord_id'=>$request->get('owner_id'),
        ]);
        return redirect()->route('model-contracts.show',$request->get('owner_id'));
    }

    // Read

    public function show($owner_id){
        $models = ModelContract::where('landlord_id',$owner_id)->get();
        return view('contract.model.list', 
        ['models'=>$models]
    );
    }

    // Update

    public function update(Request $request, $id,$owner_id){
        ModelContract::find($id)->update([   
            'name'=>$request->get('name'),
            'content'=>$request->get('content')
    ]);


        return redirect()->route('model-contracts.show',$owner_id);
    }

    public function edit($id){
        return view('contract.model.edit', [
            'model'=>ModelContract::find($id), 
        ]);
    }

    // Delete

    public function destroy(Request $request, $id, $owner_id)
    {
        ModelContract::destroy($id);

        return redirect()->route('model-contracts.show',$owner_id);
    }
}
