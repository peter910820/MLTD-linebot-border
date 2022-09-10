<?php 
 
require_once 'src/push.php';
require_once 'src/spider_class.php';

$ChannelSecret = getenv('CHANNEL_SECRET'); 
$ChannelAccessToken = getenv('CHANNEL_ACCESSTOKEN'); 
 
//讀取資訊 
$HttpRequestBody = file_get_contents('php://input'); 
$HeaderSignature = $_SERVER['HTTP_X_LINE_SIGNATURE']; 

$Hash = hash_hmac('sha256', $HttpRequestBody, $ChannelSecret, true); 
$HashSignature = base64_encode($Hash); 
if($HashSignature != $HeaderSignature) 
{ 
    die('hash error!'); 
} 
$DataBody=json_decode($HttpRequestBody, true);
$tool = new tool();
$spider = new spider_class();
$eventData = $spider->event_data();
//when bot take over message
foreach($DataBody['events'] as $Event){
    if($Event['type'] == 'message'){
        if(preg_match("/^[e][v][e][n][t][-][a-z]{2}$/", $Event['message']['text'])){
            $mode_parmeter = substr($Event['message']['text'],6,2);
            $Payload = $spider->spider($mode_parmeter, $Event, $eventData);
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }elseif(preg_match("/^[e][v][e][n][t][-][a-z]{2}[-][0-9]*$/", $Event['message']['text'])){
            $mode_parmeter = substr($Event['message']['text'],6,2);
            $rank = substr($Event['message']['text'],9);
            $Payload = $spider->boder_single($mode_parmeter, $rank, $Event, $eventData);
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }elseif($Event['message']['text'] =='$version'){
            $content = $spider->version($Event);
            $Payload = $content;
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }elseif($Event['message']['text'] =='test'){
            $content = $spider->sat($Event);
            $Payload = $content;
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }
    else print_r('This request is not a message type');
    }
    
    
}
//輸出 
//file_put_contents('tool/log.txt', $HttpRequestBody); 
