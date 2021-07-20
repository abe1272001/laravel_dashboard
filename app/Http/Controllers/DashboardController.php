<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->get('user')) {
            $data = User::paginate(15);
            // dd($data);
            return view('dashboard.index', ['users'=>$data]);
        } else {
            return redirect()->route('home');
        }
    }

    public function search(Request $request) 
    {
        if(isset($_GET['email']) && isset($_GET['name']) && isset($_GET['id'])) {
            $email_query = $_GET['email'];
            $id_query = $_GET['id'];
            $name_query = $_GET['name'];
            $users = DB::table('users');
            if ($email_query !== '') {
                $users->where('email',  "LIKE",  "%" . $email_query . "%");
            }
            if($id_query !== '') {
                $users->where('user_id',  "=", $id_query);
            }
            if($name_query !== '') {
                $users->where('name',  "LIKE",  "%" . $name_query . "%");
            }
            // if(($email_query !== '' && $id_query !== '' && $name_query !== '') {
            //     $data = $users->paginate(15);
            //     return view('dashboard.index', ['users'=>$data]);
            // }
            $data = $users->paginate(15)->appends($request->all());
            // dd($data);
            return view('dashboard.index', ['users'=>$data]);
            // dd($search_params);
        }
        // $search_params = str_replace($request->url(), '',$request->fullUrl());
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
