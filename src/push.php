<?php

class tool{

    function crul_handle($Payload, $ChannelAccessToken){

        // 傳送訊息
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/reply');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $ChannelAccessToken
        ]);
        $Result = curl_exec($ch);
        curl_close($ch);
        return $Result;
    }

    function sat($Event){
        $Payload = [
            'replyToken' => $Event['replyToken'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' => '安安優~'
                ]
            ]
        ];
        
        return $Payload;
    }

}