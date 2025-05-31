<?php
class Message extends Client
{
    public $condition;
    public $MessageData ;
    public function __construct($token = null){
        if(is_null($token)){
            $token = file_get_contents("token.txt");
        }
        $this -> MessageData = new MessageData();
        parent::__construct($token);
    }
    public function handle_message($update) {
        if($this -> OnMessageType($update , "photo")){
            $this -> condition = new Condition();
            $conditions = $this -> condition -> dump();
            foreach($conditions['OnText'] as $entity){
                if($entity['regex'] && preg_match( $entity["data"]['equal'] , $this->MessageData -> getData($update)['text'] )) {
                    if(function_exists($entity['function'])){
                        $entity['function']($update);
                    }else{
                        $func = file_get_contents($this -> condition -> path.'functions/'.$entity['uniq'].".php");
                        eval($func);
                        $entity['function']($update);
                    }

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
        }
        return true;
    }
    public function SendMessage($text , $update , $additional_setting = []) {
        if(is_array($text)){
            $text = $this -> MessageData -> getData($update)['text'];
        }
        if(is_array($update)){
            $chatID =  $this -> MessageData -> getData($update)['chat_id'];
        }
        parent::request('sendMessage',array_merge(
            [
                'chat_id' => $chatID,
                'text' => $text,

            ] , $additional_setting
        ));
    }
    public function SendPhoto($photo , $update , $additional_setting = [] , $index = 0) {
        if(is_array($photo)){
            $photo = $this -> MessageData -> getData($update)['photo'][$index]['file_id'];
        }else if(file_exists($photo)){
            $photo = new CURLFile($photo);
        }
        if(is_array($update)){
            $chatID =  $this -> MessageData -> getData($update)['chat_id'];
        }
        return parent::request('sendPhoto',array_merge(
            [
                'chat_id' => $chatID,
                'photo' => $photo,
            ] , $additional_setting
        ));

    }
    public function SendAudio($audio , $update , $additional_setting = []) {
        if(file_exists($audio)){
            $audio = new CURLFile($audio);
        }
        if(is_array($update)){
            $chatID =  $this -> MessageData -> getData($update)['chat_id'];
        }
        return parent::request('sendAudio',array_merge(
            [
                'chat_id' => $update['message']['chat']['id'],
                'audio' => $audio,
            ] , $additional_setting
        ));
    }
    public function SendDocument($doc , $update , $additional_setting = []) {
        if(file_exists($doc)){
            $doc = new CURLFile($doc);
        }
        if(is_array($update)){
            $chatID =  $this -> MessageData -> getData($update)['chat_id'];
        }
        return parent::request('sendDocument',array_merge(
            [
                'chat_id' => $update['message']['chat']['id'],
                'document' => $doc,
            ] , $additional_setting
        ));

    }
    public function sendVideo($vid , $update , $additional_setting = []) {
        if(file_exists($vid)){
            $vid = new CURLFile($vid);
        }
        if(is_array($update)){
            $chatID =  $this -> MessageData -> getData($update)['chat_id'];
        }
        return parent::request('sendVideo',array_merge(
            [
                'chat_id' => $update['message']['chat']['id'],
                'video' => $vid,
            ] , $additional_setting
        ));
    }
    public function sendVoice($voice , $update , $additional_setting = []) {
        if(file_exists($voice)){
            $voice = new CURLFile($voice);
        }
        if(is_array($update)){
            $chatID =  $this -> MessageData -> getData($update)['chat_id'];
        }
        return parent::request('sendVoice',array_merge(
            [
                'chat_id' => $update['message']['chat']['id'],
                'voice' => $voice,
            ] , $additional_setting
        ));

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



}