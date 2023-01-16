<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdentificationTypeCreateRequest;
use App\Http\Requests\IdentificationTypeUpdateRequest;
use App\Models\IdentificationType;
use Illuminate\Http\Request;

class IdentificationTypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = IdentificationType::all();

        return $this->successResponse($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdentificationTypeCreateRequest $request)
    {
        $iTypeSaved = IdentificationType::create($request->all());

        return $this->successResponse($iTypeSaved);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IdentificationType  $identificationType
     * @return \Illuminate\Http\Response
     */
    public function show(IdentificationType $identificationType)
    {
        //
        return $this->successResponse($identificationType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IdentificationType  $identificationType
     * @return \Illuminate\Http\Response
     */
    public function update(IdentificationTypeUpdateRequest $request, IdentificationType $identificationType)
    {
        //
        $identificationType->fill($request->all());
        $identificationType->update();

        return $this->successResponse($identificationType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IdentificationType  $identificationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdentificationType $identificationType)
    {
        //
        $identificationType->delete();

        return $this->successResponse([]);
    }
}
