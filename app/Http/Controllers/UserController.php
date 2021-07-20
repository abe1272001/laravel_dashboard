<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
class UserController extends Controller
{
    //
    public function store(Request $request) 
    {
        //!測試api
        ini_set('max_execution_time', 600); //600 seconds = 10 minutes
        // dd('ddd');
        try {
            //code...
            $user = session()->get('user');
            $client = new Client([
                'base_uri' => 'http://10.140.0.4:8888/api/users',
                'headers' => [
                    'Authorization' => $user['token']
                ]
            ]);
            $response = $client->request('GET');
            $body = $response->getBody();
            $data = json_decode($body);
            // dd($data);
            if($data->result === 'success') {
                $totalPage = $data->content->last_page;

                $storeData = collect($data->content->data);
                // dump($totalPage);
                // dump($storeData);
                // dd($data);
                for ($i=1; $i <= $totalPage; $i++) { 
                    # code...
                    $client = new Client([
                        'base_uri' => "http://10.140.0.4:8888/api/users?page=$i",
                        'headers' => [
                            'Authorization' => $user['token']
                        ]
                    ]);
                    $perPageResponse = $client->request('GET');
                    $body = $perPageResponse->getBody();
                    $data = json_decode($body);
                    $storeData = collect($data->content->data);
                    foreach ($storeData as $key => $item) {
                        # code...
                        $storeAry = [
                            'user_id' => $item->id,
                            'name' => $item->name,
                            'email' => $item->email,
                        ];
                        $person = User::create($storeAry);
                        // ($storeAry) ;
                    }
                    // dump($storeData);
                }
                return redirect()->route('dashboard');
                // dd($data);
                
            }
            
        } catch (ClientException  $e) {
            //throw $th;
            $response = $e->getResponse()->getBody();
            $body = json_decode($response);
            if($body->result === 'failure') {
                // dd($body);
                return back()->with('error', $body);
            }
        }
        
    }

    public function destroy()
    {
        //!寫truncate
        User::query()->truncate();
        return redirect()->route('dashboard');
    }
}
