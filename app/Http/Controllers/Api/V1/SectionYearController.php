<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\SectionYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionYearRequest;
use App\Http\Resources\SectionYearResource;

class SectionYearController extends Controller
{

    public function index()
    {
        $sy = cache()->remember(
            'allSectionYears',
            now()->addDay(),
            function(){
                return SectionYear::all();
            }
        );
        return SectionYearResource::collection($sy);
    }


    public function store(SectionYearRequest $request)
    {
        try{
            $sy = SectionYear::create([
                's_y' => $request->s_y
            ]);
            return $this->return_success($sy);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(SectionYearRequest $request, SectionYear $sy)
    {
        try{
            $sy->s_y = $request->s_y;
            return $this->return_success($sy);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }


    public function destroy(SectionYear $sy)
    {
        try{
            $sy->delete();
            return $this->return_success('Deleted successfully');
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(  Exception $e){
            return $this->return_error($e);
        }
    }
}
