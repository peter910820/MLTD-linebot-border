<?php


class spider_class{   
    function spider($mode_parmeter, $Event){
        switch($mode_parmeter){
            case "t":
                $parmeter = "eventPoint";
                $title_parmeter = "PT榜線";
            break;
            case "s":
                $parmeter = "highScore";
                $title_parmeter = "高分榜線";
            break;
        }
        $handle = fopen("https://api.matsurihi.me/mltd/v1/events/220/rankings/logs/".$parmeter."/1,2,3,100,2000,2500,5000,10000,25000,50000,100000?prettyPrint=true","rb");
        $content = "";
        $text = "";
        while (!feof($handle)) {
            $content .= fread($handle, 10000);
        }
        fclose($handle);
        $content = json_decode($content,true);
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
}