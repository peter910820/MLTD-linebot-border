# MLTD-linebot-border
使用PHP開發的LineBot,用於查MLTD日版榜線

## LineBot URL
![img](./QRcode.png)

## 指令集

跟bot聊天時輸入:
```console
event-pt-{名次}
event-hs-{名次}
event-lp-{名次}
```
分別用來查詢當前活動的pt榜以及HighScore榜，若沒有加上 `-{名次}` 會使用預設方式輸出:  
pt榜預設為: 1,2,3,100,2500,5000,10000,25000,50000,100000名  
HighScore榜預設為: 1,2,3,100,2000,5000,10000,20000,100000名  
寮榜預設為: 1,2,3,10,100,250,500,1000名

## 本人Twitter

https://twitter.com/seaotterMS