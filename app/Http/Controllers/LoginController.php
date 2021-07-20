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
    public function index()
    {
        return view('auth.login');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //! 這裡寫登入
        // dd($request);
        try {
            $email = $request->email;
            $password = $request->password;
            $client = new Client();
            $body = ['email'=> $email, 'password'=> $password];
            $response = $client->request('POST','http://10.140.0.4:8888/api/auth/login', ['form_params' => $body])->getBody();
            //根據status code 做判斷, 基本上這裡是已經登入了
            $body = json_decode($response);
            // dd($body);
            if($body->result === 'success') { //*登入成功
                // abe@project-studio.cc
                // 202107120312

                //* 登入成功後要取得使用者資料
                $token = $body->content->token;
                $getUserData = $client->request('GET','http://10.140.0.4:8888/api/auth/me', [
                    'headers' => [
                        'Authorization' => $token
                    ]
                ])->getBody();

                $authData = json_decode($getUserData);

                if($authData->result === 'success') { //*驗證成功
                    $authSession = [
                        'id' => $authData->content->id,
                        'name' => $authData->content->name,
                        'email'=> $authData->content->email,
                        'token'=> $token
                    ];
                    // dd($authSession);
                    session(['user' => $authSession]);
                    // dd($authData);
                    return redirect()->route('dashboard');
                } elseif ($authData->result === 'failure') {  //!驗證失敗
                    return back()->with('error', $authData->message);
                }
            }
        }
        catch (ClientException  $e){ //!登入失敗
            // dd($e);
            $response = $e->getResponse()->getBody();
            $body = json_decode($response);
            if($body->result === 'failure') {
                // dd($body);
                $request->flash();
                return back()->with('error', $body);
            }
            // dd($body);
            // echo Psr7\Message::toString($e->getRequest());
            // echo Psr7\Message::toString($e->getResponse());
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update() //Request $request, $id
    {
        //* 寫更新token
        try {
            //code...
            $user = session()->get('user');
            $client = new Client();
            // dd($user);
            $refreshData = $client->request('POST','http://10.140.0.4:8888/api/auth/refresh', [
                'headers' => [
                    'Authorization' => $user['token']
                ]
            ])->getBody();

            $response = json_decode($refreshData);
            if($response->result === 'success') { //* refresh 成功
                // dump($user);
                $user['token'] = $response->content->token;
                // dd($user);
            }
            // session()->forget('user');
            // session([
            //     'user' => $authData
            // ]);
            return redirect()->route('dashboard')->with('tokenStatus', $response->result);
        } catch (ClientException  $e) {
            //throw $th;
            $response = $e->getResponse()->getBody();
            $body = json_decode($response);
            if($body->result === 'failure') { //! refresh 失敗
                // dd($body);
                session()->forget('user');
                return redirect()->route('login');
            }
        }
        
    }

    public function destroy()
    {
        //!這裡寫登出
        session()->forget('user');
        return redirect()->route('home');
    }
}
