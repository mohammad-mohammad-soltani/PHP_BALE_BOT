<?php
class MessageData{
    public function getData($update){
        $data = [];
        if(isset($update['message']['text'])) {$data['text'] = $update['message']['text'];$data['chat_id'] = $update['message']['chat']['id'];}
        else if(isset($update['message']['caption'])) {$data['text'] = $update['message']['caption'];$data['chat_id'] = $update['message']['chat']['id'];}
        else $data['text'] = false;
        if(isset($update['message']['photo'])) $data['photo'] = $update['message']['photo'];
        return $data;
    }
}