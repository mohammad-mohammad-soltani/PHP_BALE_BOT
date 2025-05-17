<?php
class Client{
    public $token;
    public $wait_list;
    public $callback;
    public function __construct($token){
        $this->token = $token;
    }
    public function request($method, $data) {
        $url = "https://tapi.bale.ai/bot{$this -> token}/{$method}";
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        }
        $response = json_decode($result, true);
        if (!$response || !$response['ok']) {
            return false;
        }
        return $response;
    }
    public function new_message($update) {
        $this -> wait_list[$update["update_id"]] = $update;
        $req = $this -> message -> handle_message($update);
        if($req) {
            unset($this -> wait_list[$update["update_id"]]);
        }else{
            echo "have an error";
            while(!$req){
                $req = $this -> message -> handle_message($update);
                if($req) {
                    unset($this -> wait_list[$update["update_id"]]);
                    break;
                }else{
                    echo "have an error";
                }
                sleep($this -> sleep / 1000);
            }
        }
        return true;
    }
}