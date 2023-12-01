<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Department::class,'department');
    }

    public function index()
    {
        try{
            $departments =Department::all();
            return $this->return_success(DepartmentResource::collection( $departments));
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store(DepartmentRequest $request)
    {
        try{
            $department =  Department::create([
                'name' => $request->name
            ]);
            return $this->return_success($department);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }

    }

    public function update(DepartmentRequest $request, Department $department)
    {
        try{

            $department->name = $request->name;
            $department->save();
            return $this->return_success($department);

        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function destroy(Department $department)
    {
        try{
            $department->delete();

            return $this->return_success('Deleted successfully');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }
}
