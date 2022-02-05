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
foreach($DataBody['events'] as $Event)
{
        //當bot收到任何訊息
        if($Event['type'] == 'message' and $Event['message']['text'] =='安安')
        {   
            $content = $tool->sat($Event);
            $Payload = $content;
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }elseif($Event['type'] == 'message' and $Event['message']['text'] =='event'){
            $spider= new spider_class();
            $mode_parmeter = substr($Event['message']['text'],-1);
            $Payload = $spider->spider($mode_parmeter, $Event);
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }elseif($Event['type'] == 'message' and preg_match("/^[e][v][e][n][t][-][a-z0-9-]{2}$/", $Event['message']['text'])){
            $spider= new spider_class();
            $mode_parmeter = substr($Event['message']['text'],-1);
            $Payload = $spider->spider($mode_parmeter, $Event);
            $handle = $tool->crul_handle($Payload, $ChannelAccessToken);
        }
    
}
//輸出 
//file_put_contents('tool/log.txt', $HttpRequestBody); 
