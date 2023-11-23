<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluateeResource;
use App\Http\Resources\UserResource;
use App\Models\Klass;
use App\Models\KlassSection;
use App\Models\SectionYear;

class UserController extends Controller
{

    public function index()
    {
        $users = cache()->remember(
            'AllUsers',
             3600,
            function () {
            return  User::with(['role','userInfo','departments','sectionYearsPerUser'])->get();
        });
        // $users = User::with(['roles','userInfo','departments','sectionYearsPerUser'])->get();

        return  UserResource::collection($users);
    }

    public function getUserInfo()
    {
        $user = cache()->remember(
            'getUserInfo' . auth()->user()->id_number,
            now()->addDay(),
            function(){
            return  User::with([
                'departments',
                'role',
                'userInfo',
                'sectionYearsPerUser.klasses',
                'sectionYearsPerUser.klasses.evaluatee',
                'sectionYearsPerUser.klasses.subject',
            ])->findOrFail(auth()->user()->id_number);
            }
        );
        return new UserResource($user);

    }

    public function getUser()
    {

        $user = cache()->remember(
            'getUser',
            now()->addDay(),
            function(){
                return User::with('role')
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
