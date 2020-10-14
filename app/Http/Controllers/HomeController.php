<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Connection;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $q = $request->search;
            $output = "";
            $users = User::with('technology')->whereHas('technology', function($query) use($q) {
                $query->orWhere('name', 'LIKE', '%'. $q .'%');
            })->where('first_name','LIKE','%'.$request->search."%")->orWhere('last_name','LIKE','%'.$request->search.'%')->orWhere('email','LIKE','%'.$request->search.'%')->orWhere('phone_number','LIKE','%'.$request->search.'%')->where('id', '!=', Auth::user()->id)->get();

                    foreach ($users as $key => $user) {
                        $tec = "";
                        foreach($user->technology as $tech){
                               $tec .= $tech->name . '|';
                        }
                        $output = '<table border="1"><tr>' .
                        '<td colspan="2">' . $user->id . '</td>' .
                        '<td>' . $user->first_name . '</td>' .
                        '<td>' . $user->last_name . '</td>' .
                        '<td>' . $user->phone_number . '</td>' .
                        '<td>' . $user->email . '</td>' .
                        '<td>' .  $tec . '</td>' .
                        '<td><button class="connectUser" data-id="'.$user->id.'" data-action="1" id="accept">Accept</button></td>' .
                        '<td><button class="connectUser" data-id="'.$user->id.'" data-action="0" id="reject">Reject</button></td>' .
                        '</tr></table>';

            }
             return response()->json([  
                'status' => 'success',
                'response' => $output
            ]);
        }

    }

    public function connectUser(Request $request){
        if ($request->ajax()) {
            $connectionId = $request->user_id;
            $action = $request->action;

            $connection = Connection::create([
                'user_id' => Auth::user()->id,
                'connection_id' => $connectionId,
                'is_connected' => $action
            ]);

        }

        if($connection->id > 0){
            return response()->json([
                'status'=> 'success',
                'response'=>'User connected successfully!',
                //'redirect' => route('home', $connection->id)
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'response' => 'Something went wrong!'
            ]);
        }
    }
}
