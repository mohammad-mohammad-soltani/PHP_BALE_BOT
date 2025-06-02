<?php
class MessageData{
    public function getData($update){
        $data = [
            'photo' => false,
            'text' => false,
            'audio' => false,
            'video' => false,
            'document' => false,
            'voice' => false,
            'chat_id' => false,
            'from_chat_id' => false,
            'message_id' => false,
        ];
        if(isset($update['message']['text'])) {$data['text'] = $update['message']['text'];}
        else if(isset($update['message']['caption'])) {$data['text'] = $update['message']['caption'];}
        if(isset($update['message']['photo'])) $data['photo'] = $update['message']['photo'];$data['chat_id'] = $update['message']['chat']['id'];
        if(isset($update['message']['audio'])) $data['audio'] = $update['message']['audio'];
        if(isset($update['message']['document'])) $data['document'] = $update['message']['document'];
        if(isset($update['message']['video'])) $data['video'] = $update['message']['video'];
        if(isset($update['message']['voice'])) $data['voice'] = $update['message']['voice'];
        if(isset($update['message']['chat']['id'])) {$data['message_id'] = $update['message']['message_id'];$data['chat_id'] = $update['message']['chat']['id'];}
        return $data;
    }
}