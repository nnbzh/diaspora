<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestModel;
use App\Services\Push\PushNotifications;


class RequestController extends Controller
{
    public function index()
    {
        return view('Inquiries.inquiries',
            [
                'requests' => RequestModel::where('status', 0)->orderby('created_at', 'desc')->paginate(6)
            ]
        );
    }


    //Post to the POST web page where accepted posts only
    public function postIndex(){
        return view('Ads.ads',
            [
                'requests' => RequestModel::where('status', '!=', '404')->orderby('created_at', 'desc')->paginate(6)
            ]
        );
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

    //Accept the post and make it active changing its status to 1
    public function AcceptRejectPost(Request $request, $id){
        $push = new PushNotifications;
        $post = RequestModel::where('id', $id)->first();
        $tokens = \App\Models\DeviceToken::where('user_id', $post->user_id)->get();
        if($request['operation'] === 'accept'){
            RequestModel::findOrFail($id)->update(
                [
                    'status' => 1
                ]
            );
            $send_data = [
                'title' => 'Ваш запрос успешно принят',
                'body' => null,
            ];
            $adt = ['post_id' => $post->id];
            try {
                foreach ($tokens as $dt) $push->sendPush($dt->token, $send_data, $adt);
            } catch (\Exception $e) {
                $a = 0;
            }
            return back()->with('success', 'Запрос под номером ' . $id . ' был успешно принят!');
        }
        else{
            RequestModel::findOrFail($id)->update(
                [
                    'status' => 404
                ]
            );
            $send_data = [
                'title' => 'Ваш запрос успешно принят',
                'body' => null,
            ];
            $adt = ['post_id' => $post->id];
            foreach ($tokens as $dt) {
                $push->sendPush($dt->token, $send_data, $adt);
            }
            return back()->with('success', 'Запрос под номером ' . $id . ' был успешно откланен!');
        }
    }


    //Update post status when it was accepted
    public function updatePostStatus($id){
        $post = RequestModel::where('id', $id)->get()->first();
        if($post->status === 1){
            RequestModel::where('id', $id)->update(
                [
                    'status' => 0
                ]
            );

            return back()->with('success', 'Пост успешно диактивирован!');
        }
        else{
            RequestModel::where('id', $id)->update(
                [
                    'status' => 1
                ]
            );

            return back()->with('success', 'Пост успешно активирован!');
        }
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
