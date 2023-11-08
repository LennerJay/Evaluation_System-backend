<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluateeResource;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with(['roles','userInfo','departments'])->get();
        return  UserResource::collection($users);
    }

    public function getUser()
    {
        $user = cache()->remember(
                'getUser',
                now()->addDay(),
                function(){
                 return User::with([
                        'departments',
                        'roles',
                        'userInfo',
                        'sectionYears'
                            => function($query){
                            $query->with([
                                'klasses'
                                => function($q){
                                    $q->with(['subject','evaluatee']);
                                }
                            ]);
                        }
                    ])
                    ->findOrFail(auth()->user()->id_number);
                }
        );

        // return response()->json($user);
        return new UserResource($user);

    }

    public function getEvaluateesToRate(User $user){
        $evaluatees = $user->evaluatees()->with(['roles','departments'])->get();
        // return response()->json( $evaluatees);
        return EvaluateeResource::collection($evaluatees);
    }

    // public function getEvaluateesToRate(Request $request){
    //     $user = User::with([
    //                         'evaluatees' => function ($q){
    //                             $q->with(['roles','departments']);
    //                     }
    //                     ])
    //                     ->findOrFail($request->user_id);
    //     return response()->json( $user );
    //     // return EvaluateeResource::collection( $user );
    // }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
