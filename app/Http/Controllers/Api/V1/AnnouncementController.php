<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use PDOException;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{

    public function index()
    {
        try{
            return $this->return_success(Announcement::all());
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function store(Request $request)
    {
        try{
            $announcement = Announcement::create([
                'announcement' => $request->announcement
            ]);
            return $this->return_success( $announcement);
        }catch(PDOException $e){
            return $this->return_error($e->getMessage());
        }catch(Exception $e){
            return $this->return_error($e->getMessage());
        }
    }



    public function update(Request $request, Announcement $announcement)
    {
        try{
            $announcement->announcement = $request->announcement;
            $announcement->save();
            return $this->return_success( $announcement);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function destroy(Announcement $announcement)
    {
        try{
            $announcement->delete();
            return $this->return_success("Successfully deleted");
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function fetchLatestAnnouncement()
    {
        try{
            return $this->return_success(Announcement::all());
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

    public function updateStatus(Announcement $a)
    {
        try{
            $a->status = !$a->status;
            $a->save();
            return $this->return_success( $a);
        }catch(PDOException $e){
            return $this->return_error($e);
        }catch(Exception $e){
            return $this->return_error($e);
        }
    }

}
