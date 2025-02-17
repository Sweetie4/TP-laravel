<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModelContract;
use Illuminate\Http\Request;

class ModelContractController extends Controller
{

    /**
     * Create a contract model
     * @param Request $request new contract model's data
     */
    public function store(Request $request)
    {
        ModelContract::insert([
            'name' => $request->get('name'),
            'content' => $request->get('content'),
            'landlord_id' => $request->get('owner_id'),
        ]);
        return redirect()->route('model-contracts.show', $request->get('owner_id'));
    }


    /**
     * List all contract models
     * @param int $owner_id authenticated user's id
     */
    public function show($owner_id)
    {
        $models = ModelContract::where('landlord_id', $owner_id)->get();
        return view(
            'contract.model.list',
            ['models' => $models]
        );
    }

    /**
     * Edit contract model 
     * @param Request $request updated data for contract model
     * @param int $id contract model's id
     * @param int $owner_id authenticated user's id
     */
    public function update(Request $request, $id, $owner_id)
    {
        ModelContract::find($id)->update([
            'name' => $request->get('name'),
            'content' => $request->get('content')
        ]);
        return redirect()->route('model-contracts.show', $owner_id);
    }


    /**
     * View to edit contract models
     * @param int $id contract model's id to edit
     */
    public function edit($id)
    {
        return view('contract.model.edit', [
            'model' => ModelContract::find($id),
        ]);
    }

    /**
     * Delete a contract model
     * @param Request $request
     * @param int $id deleted contract model's id
     * @param int $owner_id authenticated user's id
     */
    public function destroy(Request $request, $id, $owner_id)
    {
        ModelContract::destroy($id);
        return redirect()->route('model-contracts.show', $owner_id);
    }
}
