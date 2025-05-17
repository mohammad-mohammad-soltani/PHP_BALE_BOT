<?php
class Stream extends Client{
    public $message;
    public $condition;
    public function __construct($token ){
        parent::__construct($token);
        $this -> message = new Message($token);
        $this -> condition = new Condition();
    }
    public function connect($sleep = 100){
        $this -> wait_list = [];
        $offset = -1;
        while(true){
            $req = parent::request("getUpdates", ['offset' => $offset]);
            if(!$req){
                echo "getUpdates failed\n";
                break;
            }else if(count($req['result']) >= 1){
                $req['result'] = array_reverse($req["result"]);
                $offset = $req["result"][0]['update_id'] + 1;
                foreach($req["result"] as $update){
                    parent::new_message($update);
                }
            }
            sleep($sleep / 1000);
        }
    }

}