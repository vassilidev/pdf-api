<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContractRequest;
use App\Http\Requests\Api\StoreContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ContractResource::collection(
            resource: Contract::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractRequest $request): ContractResource
    {
        $contract = Contract::create($request->validated());

        return new ContractResource($contract);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract): ContractResource
    {
        return new ContractResource($contract);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractRequest $request, Contract $contract): ContractResource
    {
        $contract->update($request->validated());

        return new ContractResource($contract);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract): JsonResponse
    {
        $contract->delete();

        return response()->json('Contract deleted.');
    }
}
