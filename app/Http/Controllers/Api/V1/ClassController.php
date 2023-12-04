<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\ClassControllerService\ClassService;

class ClassController extends Controller
{
    public function storeClass(Request $request)
    {
        try{

            $result = (new ClassService)->saveClass($request);
            return $this->return_success($result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    public function updateClass()
    {
        try{

            return $this->return_success('test');
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }

    function deleteClass()
    {
        try{

            return $this->return_success('test');
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }
}
