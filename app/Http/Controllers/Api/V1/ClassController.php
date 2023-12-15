<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Http\Controllers\Controller;
use App\Http\Requests\KlassDetailRequest;
use App\Service\Controller\ClassService;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function storeClass(KlassDetailRequest $request)
    {
        try{
            $result = (new ClassService)->saveUpdateClass($request);
            return $this->return_success( $result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }


    function deleteClass(Request $request)
    {
        try{
            $result = (new ClassService)->deleteClass($request);
            return $this->return_success( $result);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }
}
