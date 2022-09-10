<?php

class spider_class{   
    function spider($mode_parmeter, $Event, $eventData){
        switch($mode_parmeter){
            case "pt":
                $parmeter = "eventPoint";
                $title_parmeter = "PT榜線";
                $handle = fopen("https://api.matsurihi.me/mltd/v1/events/".$eventData[0]."/rankings/logs/$parmeter/1,2,3,100,2500,5000,10000,25000,50000,100000?prettyPrint=true","rb");
            break;
            case "hs":
                $parmeter = "highScore";
                $title_parmeter = "高分榜線";
                $handle = fopen("https://api.matsurihi.me/mltd/v1/events/".$eventData[0]."/rankings/logs/$parmeter/1,2,3,100,2000,5000,10000,20000,100000?prettyPrint=true","rb");
            break;
            case "lp":
                $parmeter = "loungePoint";
                $title_parmeter = "寮榜線";
                $handle = fopen("https://api.matsurihi.me/mltd/v1/events/".$eventData[0]."/rankings/logs/$parmeter/1,2,3,10,100,250,500,1000?prettyPrint=true","rb");
            break;
        }
        $content = "";
        $text = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $content = json_decode($content,true);
        $text .= "$eventData[1]\n開始時間:$eventData[2]\n結束時間:$eventData[3]\n";
        $text .= "======================\n";
        $text .= $title_parmeter."  (名次/分數/半小時增加量)\n";
        foreach($content as $rank){
            $array[] = strlen($rank['data'][count($rank['data'])-1]['score']);
            arsort($array);
        }
        
        foreach($content as $rank){
            $gap = $rank['data'][count($rank['data'])-1]['score']-$rank['data'][count($rank['data'])-2]['score'];
            $text .= str_pad($rank['rank'].'位',8).str_pad($rank['data'][count($rank['data'])-1]['score']."pt",$array[0]+7," ",STR_PAD_LEFT)."   (+$gap".")\n";
        }
        $text .= "======================";
        $Payload = [
            'replyToken' => $Event['replyToken'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $text
                ]
            ]
        ];
        
        return $Payload;
    }
    function boder_single($mode_parmeter, $rank, $Event, $eventData){
        switch($mode_parmeter){
            case "pt":
                $parmeter = "eventPoint";
                $title_parmeter = "PT榜線";
            break;
            case "hs":
                $parmeter = "highScore";
                $title_parmeter = "高分榜線";
            break;
            case "lp":
                $parmeter = "loungePoint";
                $title_parmeter = "寮榜線";
            break;
        }
        $handle = fopen("https://api.matsurihi.me/mltd/v1/events/".$eventData[0]."/rankings/logs/".$parmeter."/$rank?prettyPrint=true","rb");
        $content = "";
        $text = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $content = json_decode($content,true);
        $text .= "$eventData[1]\n開始時間:$eventData[2]\n結束時間:$eventData[3]\n";
        $text .= "======================\n";
        $text .= $title_parmeter."  (名次/分數/半小時增加量)\n";
        foreach($content as $rank){
            $gap = $rank['data'][count($rank['data'])-1]['score']-$rank['data'][count($rank['data'])-2]['score'];
            $text .= $rank['rank'].'位   '.$rank['data'][count($rank['data'])-1]['score']."pt"."  (+$gap".")\n";
        }
        $text .= "======================";
        $Payload = [
            'replyToken' => $Event['replyToken'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $text
                ]
            ]
        ];
        
        return $Payload;
    }
    function event_data(){
        $handle = fopen("https://api.matsurihi.me/mltd/v1/events","rb");
        $content = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $content = json_decode($content,true);
        $eventData = array();
        $id = $content[count($content)-1]['id'];
        $name = $content[count($content)-1]['name'];
        $beginDate = $content[count($content)-1]['schedule']['beginDate'];
        $endDate = $content[count($content)-1]['schedule']['endDate'];
        array_push($eventData, $id, $name, $beginDate, $endDate);
        return $eventData;
    }
    function version($Event){
        $handle = fopen("https://api.matsurihi.me/mltd/v1/version/assets","rb");
        $content = "";
        $text = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $content = json_decode($content,true);
        $text .= $content[count($content)-1]['version'];
        $Payload = [
            'replyToken' => $Event['replyToken'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' =>  $text
                ]
            ]
        ];
        return $Payload;
    }
    function sat($Event){
        $Payload = [
            'replyToken' => $Event['replyToken'],
            'messages' => [
                [
                    'type' => 'text',
                    'text' => 'test complete!'
                ]
            ]
        ];
        return $Payload;
    }
}