<?php

namespace App\Http\Controllers;

// use App\Models\Criteria;

use App\Models\User;
use App\Models\Klass;
use App\Models\Rating;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Evaluatee;
use App\Models\Instructor;
// use App\Models\Rating;
use App\Models\Questionaire;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Eval_;
use App\Http\Resources\UserResource;
use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $instructor = 1;

        // $question = 1;
        // $instructor = Instructor::withCount(['ratings as NI_count'=> function(Builder $q)use($question){
        //                                 $q->where('question_id', $question)->where('rating', 1);
        //                             },
        //                             'ratings as F_count'=> function(Builder $q)use($question ){
        //                                 $q->where('question_id', $question)->where('rating',2);
        //                             },
        //                             'ratings as S_count'=> function(Builder $q)use($question ){
        //                                 $q->where('question_id', $question)->where('rating',3);
        //                             },
        //                             'ratings as VS_count'=> function(Builder $q)use($question ){
        //                                 $q->where('question_id', $question)->where('rating',4);
        //                             },'ratings as O_count'=> function(Builder $q)use($question ){
        //                                 $q->where('question_id', $question)->where('rating',5);
        //                             },
        //                         ])
        //                         ->where('id', $instructor)
        //                         ->get(['id','name']);
        // return response()->json($instructor);
        // $rating = Rating::with('question')
        // return response()->json($rating );
        //                     ->get();
        // withCount(['ratings'=> function(Builder $query){
        //     $query->whereHas('ratingable',function($q){
        //             $q->whereKey($ins);
        //         });
        //      }])
            // $rating = Rating::whereHasMorph(
            //                         'ratingable',
            //                         Instructor::class,
            //                         function(Builder $query){
            //                             $query->where('ratingable_id',1)
            //                                   ->where('question_id',1);
            //                         }
            //                       )
                                //   ->withCount(['ratings'=>function( $q){
                                //     $q->where('rating',1);
                                // }])

            //                       ->get();
            // return response()->json($rating);
            // $questions = Question::withCount(['ratings as NI_counts'=>function($query){
                                            // $query->whereHasMorph(
                                            //     'ratingable',
                                            //     Instructor::class,
                                            //     function(Builder $q){
                                            //         $q->where('ratingable_id',1)
                                            //             ->where('rating',1);
                                            //     });
            //                             },
            //                             'ratings as F_counts'=>function($query){
            //                                 $query->whereHasMorph(
            //                                     'ratingable',
            //                                     Instructor::class,
            //                                     function(Builder $q){
            //                                         $q->where('ratingable_id',1)
            //                                             ->where('rating',2);
            //                                     });
            //                             },
            //                             'ratings as S_count'=>function($query){
            //                                 $query->whereHasMorph(
            //                                     'ratingable',
            //                                     Instructor::class,
            //                                     function(Builder $q){
            //                                         $q->where('ratingable_id',1)
            //                                             ->where('rating',3);
            //                                     });
            //                             },
            //                             'ratings as VS_count'=>function($query){
            //                                 $query->whereHasMorph(
            //                                     'ratingable',
            //                                     Instructor::class,
            //                                     function(Builder $q){
            //                                         $q->where('ratingable_id',1)
            //                                             ->where('rating',4);
            //                                     });
            //                             },
            //                             'ratings as O_count'=>function($query){
            //                                 $query->whereHasMorph(
            //                                     'ratingable',
            //                                     Instructor::class,
            //                                     function(Builder $q){
            //                                         $q->where('ratingable_id',1)
            //                                             ->where('rating',5);
            //                                     });
            //                             },
            //                         ])
            //                         ->with('criteria')
            //                         // ->where('criteria_id',1)
            //                         // ->where('id',1)
            //                         ->get();
            // return response()->json($questions);
            $id = 1;
            $questionaire = Questionaire::find(1);
            $questions =  $questionaire->criterias()
                                        ->with([
                                            'questions'
                                             =>function($q){
                                                $q->where('id',1);
                                            }
                                            ,
                                            'questions.ratings' =>function($query)use($id){
                                                $query->whereHasMorph(
                                                    'ratingable',
                                                    Instructor::class,
                                                    function(Builder $q)use($id){
                                                        $q->where('ratingable_id',$id)
                                                            ->where('rating',1);
                                                    });
                                            }
                                        ])
                                     ->where('id',1)
                                       ->get();
                                         return response()->json($questions);

    }
    public function test()
    {
        return view('index');
    }

    public function testModel()
    {
        // <<--- this query for evaluatee to subject
    //    $test = Evaluatee::with('subjects')->where('id',1)->get();
    //    ---->>
        // <--- this query for subject to evaluatee
        // $test = Subject::with('evaluatees')->where('id',1)->get();
        // --->>
        $t = [];
        $ids = [];
        // $user=  User::with([
        //             'userInfo',
        //             'sectionYears'
        //              => function($query){
        //               $query->with([
        //                     'klasses'
        //                     => function($q){
        //                         $q->with(['subject','evaluatee']);
        //                     }
        //                 ]);
        //             }
        //         ])
        //         ->findOrFail(10203);

        // $test = Evaluatee::with([
        //                     'klasses' => function($query){
        //                         $query->with('subject')
        //                             ->with(['sectionYears'=>function($q){
        //                                     $q->with('users');
        //                             }])
        //                             //  ->where('subject_id',5)
        //                              ->get();
        //                     }
        //                     ])
        //                     ->find(1);
        // $klasses = Klass::with('evaluatee')
        //                 ->with(['sectionYears' => function($q){
        //                     $q->with('users');
        //                 }])
        //                 ->get();
        //     // dd($klasses[0]->evaluatee);
        //     dd( $klasses[0]->sectionYears[0]->users[0]);
            // foreach($users->sectionYears as $sy){
            //     dd($sy->klasses[0]->evaluatee );
            //     // dd($sy->klasses[0]->evaluatee->id );
            //         foreach($sy->klasses as $klass){
            //             dd( $klass);
            //             // foreach($klass->evaluatee as $evaluatee){
            //             //    array_push($ids, $evaluatee->id);
            //             // }
            //         }
            // }

        // dd($ids);








    //    return response()->json($t);
    //    return new UserResource($test);

                // $test = Department::with('evaluatees')->get();
                    // $klasses = Klass::with([
                    //     'evaluatee',
                    //     'sectionYears' => function($q){
                    //         $q->with('sectionYearsPerUser');
                    //     }
                    // ])->get();



                // return view('index',compact('klasses'));
                // return response()->json($klasses);

                // $evaluatee = Evaluatee::with('klasses')->find(57);
                // //  return response()->json($evaluatee);
                // return view('index',compact('evaluatee'));
                        // $department = Department::with('evaluatees')->find(1);
                        //   return response()->json($department);

                // $sub = Subject::with('evaluatees')->find(1);
                //         return response()->json($sub);
    }
}
