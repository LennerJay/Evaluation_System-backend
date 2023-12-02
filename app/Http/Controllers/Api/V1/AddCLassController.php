<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddCLassController extends Controller
{

    public function storeClass()
    {
        try{

            return $this->return_success('test');
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
