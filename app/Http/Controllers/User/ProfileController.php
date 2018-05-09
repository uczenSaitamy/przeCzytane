<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PHPUnit\Framework\Constraint\IsFalse;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.user', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request)
    {
        $id = $request[trim('userName')];

        DB::table('friends')->insert(['nameFirst' => Auth::user()->name, 'nameSecond' => $id]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $friendship = 0;

        $user = DB::table('users')->where('name', $id)->first();

        if(Auth::user()->name != $id){
            $ffriend = DB::table('friends')
                ->select('*')
                ->where('nameSecond', Auth::user()->name)
                ->orWhere('nameFirst', Auth::user()->name)
                ->get();

            if ($ffriend->contains('nameFirst',$id)){
                $friendship = 0;
            }
            elseif ($ffriend->contains('nameSecond',$id)){
                $friendship = 0;
            }
            else{
                $friendship = 1;
            }
        }


        if ($user == null){
            abort(404);
        }
        else{
            return view('user.user', compact(['user', 'friendship']));
//            return View::creator('user.user', compact(['user', 'friendship']));
        }

    }

    public function about($id)
    {
        $user = DB::table('users')->where('name', $id)->first();
        if ($user == null){
            abort(404);
        }
        else{
            return view('user.about', compact('user'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}