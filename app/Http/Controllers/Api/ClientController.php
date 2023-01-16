<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ClientSaveRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Http\Requests\UserVerifyRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::with('user.identificationType')->get();

        return $this->successResponse($clients); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientSaveRequest $request)
    {
        $user = new User($request->all());
        $user->password = bcrypt($request->password);

        DB::transaction(function() use ($user){

            $user->save();
            $user->client()->save(new Client([]));

            // Assing Role
            $user->assignRole('client');
            
            return $this->successResponse($user);
        });

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $client)
    {
        $client->user;

        return $this->successResponse($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, client $client)
    {
        $client->user->update($request->all());

        return $this->successResponse($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(client $client)
    {
        $client->delete();

        return $this->successResponse([], 204);
    }

    /**
     * 
     */
    public function verifyClient(UserVerifyRequest $request)
    {
        $client = User::with('client')
        ->where([
            ['identification_type_id', '=', $request->identification_type_id],
            ['identification_number', '=', $request->identification_number],
        ])->first();

        return $this->successResponse($client);
    }
}