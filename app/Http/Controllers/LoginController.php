<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Session;
use GuzzleHttp\Psr7;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
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
        //! 這裡寫登入
        try {
            $email = $request->email;
            $password = $request->password;
            $client = new Client();
            $body = ['email'=> $email, 'password'=> $password];
            $response = $client->request('POST','http://10.140.0.4:8888/api/auth/login', ['form_params' => $body])->getBody();
            //根據status code 做判斷, 基本上這裡是已經登入了
            $body = json_decode($response);
            // dd($body);
            if($body->result === 'success') { //登入成功
                // abe@project-studio.cc
                // 202107120312

                //* 登入成功後要取得使用者資料
                $token = $body->content;
                // $getUserData = $client->request('GET','http://10.140.0.4:8888/api/auth/me')->getBody();
                // dd($getUserData);
                
                $user = [
                    'email'=> $email,
                    'password'=> $password,
                    'token'=> $body->content
                ];
                session(['user' => $user]);
                // dd($user);
                return redirect()->route('dashboard');
            }
        }
        catch (ClientException  $e){
            $response = $e->getResponse()->getBody();
            $body = json_decode($response);
            if($body->result === 'failure') {
                return back()->with('error', $body);
            }
            // dd($body);
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
        }
        
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
    public function destroy()
    {
        //!這裡寫登出
        session()->forget('user');
        return redirect()->route('home');
    }
}
