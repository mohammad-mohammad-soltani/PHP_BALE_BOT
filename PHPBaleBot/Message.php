<?php
class Message extends Client
{
    public $condition;
    public $MessageData ;
    public $condition_list;
    public function __construct($token = null){
        if(is_null($token)){
            $token = file_get_contents("token.txt");
        }
        $this -> MessageData = new MessageData();
        parent::__construct($token);
    }
    public function do_func($entity , $update)
    {
        if(function_exists($entity['function'])){
            $entity['function']($update);
        }else{
            $func = file_get_contents($this -> condition -> path.'functions/'.$entity['uniq'].".php");
            eval($func);
            $entity['function']($update);
        }
    }
    public function handle_message($update) {
        $this -> condition = new Condition();
        $this -> condition_list = $this -> condition -> dump();
        if($this -> OnMessageType($update , "text") && isset($this -> condition_list['OnText'])){
            foreach($this -> condition_list['OnText'] as $entity){
                if($entity['regex'] && preg_match($entity["data"]['equal'] , $this->MessageData -> getData($update)['text'])) {
                    $this->do_func($entity , $update);
                }else if( $entity["data"]['equal'] == $update['message']['text'] ){
                    if(function_exists($entity['function'])){
                        $entity['function']($update);
                    }else{
                        $func = file_get_contents($this -> condition -> path.'functions/'.$entity['uniq'].".php");
                        eval($func);
                        $entity['function']($update);
                    }
                }
            }
        }else if($this -> OnMessageType($update , "photo") && isset($this -> condition_list['OnPhoto'])){
            foreach($this -> condition_list['OnPhoto'] as $entity){
                $this->do_func($entity , $update);
            }
        }else if($this -> OnMessageType($update , "voice") && isset($this -> condition_list['OnVoice'])){
            foreach($this -> condition_list['OnVoice'] as $entity){
                $this->do_func($entity , $update);
            }
        }else if($this -> OnMessageType($update , "audio") && isset($this -> condition_list['OnAudio'])){
            foreach($this -> condition_list['OnAudio'] as $entity){
                $this->do_func($entity , $update);
            }
        }else if($this -> OnMessageType($update , "video") && isset($this -> condition_list['OnVideo'])){
            foreach($this -> condition_list['OnVideo'] as $entity){
                $this->do_func($entity , $update);
            }
        }else if($this -> OnMessageType($update , "document") && isset($this -> condition_list['OnDocument'])){
            foreach($this -> condition_list['OnDocument'] as $entity){
                $this->do_func($entity , $update);
            }
        }
        if(isset($this -> condition_list['AllMessage']) ){
            foreach ($this -> condition_list['AllMessage'] as $entity ) {
                $this->do_func($entity , $update);
            }
        }
        return true;
    }
    public function SendMessage($text , $chatID , $additional_setting = []) {
        if(is_array($text)){
            $text = $this -> MessageData -> getData($text)['text'];
        }
        if(is_array($chatID)){
            $chatID =  $this -> MessageData -> getData($chatID)['chat_id'];
        }
        parent::request('sendMessage',array_merge(
            [
                'chat_id' => $chatID,
                'text' => $text,

            ] , $additional_setting
        ));
    }
    public function SendPhoto($photo , $chatID , $additional_setting = [] , $index = 0) {
        if(is_array($photo)){
            $photo = $this -> MessageData -> getData($photo)['photo'][$index]['file_id'];
        }else if(file_exists($photo)){
            $photo = new CURLFile($photo);
        }
        if(is_array($chatID)){
            $chatID =  $this -> MessageData -> getData($photo)['chat_id'];
        }
        return parent::request('sendPhoto',array_merge(
            [
                'chat_id' => $chatID,
                'photo' => $photo,
            ] , $additional_setting
        ));
    }
    public function SendAudio($audio , $chatID , $additional_setting = []) {
        if(is_array($audio)){
            if($this -> MessageData -> getData($audio)['audio'] !== false){
                $audio = $this -> MessageData -> getData($audio)['audio']['file_id'];
            }else{
                $audio = $this -> MessageData -> getData($audio)['document']['file_id'];
            }
        }else if(file_exists($audio)){
            $audio = new CURLFile($audio);
        }
        if(is_array($chatID)){
            $chatID =  $this -> MessageData -> getData($chatID)['chat_id'];
        }
        return parent::request('sendAudio',array_merge(
            [
                'chat_id' => $chatID,
                'audio' => $audio,
            ] , $additional_setting
        ));
    }
    public function SendDocument($doc , $chatID , $additional_setting = [] , $index = 0) {
        if(is_array($doc)){
            $doc = $this -> MessageData -> getData($doc)['document'][$index]['file_id'];
        }else if(file_exists($doc)){
            $doc = new CURLFile($doc);
        }
        if(is_array($chatID)){
            $chatID =  $this -> MessageData -> getData($chatID)['chat_id'];
        }
        return parent::request('sendDocument',array_merge(
            [
                'chat_id' =>$chatID,
                'document' => $doc,
            ] , $additional_setting
        ));
    }
    public function SendVideo($vid , $chatID , $additional_setting = [] , $index = 0) {
        if(is_array($vid)){
            if($this -> MessageData -> getData($vid)['video'] !== false){
                if(!isset($this -> MessageData -> getData($vid)['video']['file_id'])){
                    $vid = $this -> MessageData -> getData($vid)['video'][$index]['file_id'];
                }else{
                    $vid = $this -> MessageData -> getData($vid)['video']['file_id'];
                }
            }else{
                $vid = $this -> MessageData -> getData($vid)['document']['file_id'];
            }
        }else if(file_exists($vid)){
            $vid = new CURLFile($vid);
        }
        if(is_array($chatID)){
            $chatID =  $this -> MessageData -> getData($chatID)['chat_id'];
        }
        return parent::request('sendVideo',array_merge(
            [
                'chat_id' => $chatID,
                'video' => $vid,
            ] , $additional_setting
        ));
    }
    public function SendVoice($voice , $chatID , $additional_setting = [] , $index = 0) {
        if(is_array($voice)){
            if($this -> MessageData -> getData($voice)['voice'] !== false){
                $voice = $this -> MessageData -> getData($voice)['voice']['file_id'];
            }else{
                $voice = $this -> MessageData -> getData($voice)['document']['file_id'];
            }
        }else if(file_exists($voice)){
            $voice = new CURLFile($voice);
        }
        if(is_array($chatID)){
            $chatID =  $this -> MessageData -> getData($chatID)['chat_id'];
        }
        return parent::request('sendVoice',array_merge(
            [
                'chat_id' => $chatID,
                'voice' => $voice,
            ] , $additional_setting
        ));
    }
    public function copyMessage($from_chat_id , $message_id , $chatID )
    {
        if(is_array($from_chat_id)){
            $from_chat_id = $this -> MessageData -> getData($from_chat_id)['chat_id'];
        }
        if(is_array($chatID)){
            $chatID = $this -> MessageData -> getData($chatID)['chat_id'];
        }
        if(is_array($message_id)){
            $message_id = $this -> MessageData -> getData($message_id)['message_id'];
        }
        return parent::request('copyMessage', ['chat_id' => $chatID , 'from_chat_id' => $from_chat_id , 'message_id' => $message_id ]);
    }
    public function OnMessageType($update , $type)
    {
        if(isset($update['message']['text']) && $type == 'text') return true;
        else if(isset($update['message']['photo']) && $type == 'photo') return true ;
        else if(isset($update['message']['audio']) && $type == 'audio') return true;
        else if(isset($update['message']['document']) && $type == 'document') return true;
        else if(isset($update['message']['video']) && $type == 'video') return true;
        else if(isset($update['message']['animation']) && $type == 'animation') return true;
        else if(isset($update['message']['sticker']) && $type == 'sticker') return true;
        else if(isset($update['message']['voice']) && $type == 'voice') return true;
        else if(isset($update['message']['caption']) && $type == 'caption') return true;
        else if(isset($update['message']['contact']) && $type == 'contact') return true;
        else if(isset($update['message']['location']) && $type == 'location') return true;
        else if(isset($update['message']['new_chat_members']) && $type == 'new_chat_members') return true;
        else if(isset($update['message']['left_chat_member']) && $type == 'left_chat_member') return true;
        else if(isset($update['message']['invoice']) && $type == 'invoice') return true;
        else if(isset($update['message']['successful_payment']) && $type == 'successful_payment') return true;
        else if(isset($update['message']['web_app_data']) && $type == 'web_app_data') return true;
        else if(isset($update['CallbackQuery']) && $type == 'CallbackQuery') return true;
        return false;
    }
    public function download_message_file($file_id , $path , $index = 0 ){
        if(is_array($file_id)){
            $file_id = $this -> MessageData -> getData($file_id)['document']['file_id'];
        }
        $file_id = parent::request('getFile' , ['file_id' => $file_id ])['result']['file_id'];
        copy(parent::get_file_path($file_id) , $path);
    }

}