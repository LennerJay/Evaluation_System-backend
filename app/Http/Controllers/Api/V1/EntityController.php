<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\Entity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EntityRequest;
use App\Http\Resources\EntityResource;

class EntityController extends Controller
{
    public function __construct()
    {
        return $this->authorizeResource(Entity::class, 'entity');
    }

    public function index()
    {
        try{
            return $this->return_success(Entity::all());
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store(EntityRequest $request)
    {
        try{
            Entity::create([
                'entity_name' => $request->entity_name,
            ]);
            return $this->return_success(Entity::all());
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function update(Entity $entity,EntityRequest $request )
    {
        try{
            $entity->entity_name = $request->entity_name;
            $entity->save();
             return $this->return_success( $entity);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function destroy(Entity $entity)
    {
        $this->authorize('delete', $entity);
        try{
            $entity->delete();
            return response()->json(['success' => 'Deleted successfully']);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }

    }
}
