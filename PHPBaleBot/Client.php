<?php
class Client{
    public $token;
    public $wait_list;
    public $callback;
    public function __construct($token){
        $this->token = $token;
    }
    public function request($method, $data , $append_url = "") {
        $url = "https://tapi.bale.ai/{$append_url}bot{$this->token}/{$method}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $hasFile = false;
        foreach ($data as $value) {
            if ($value instanceof CURLFile) {
                $hasFile = true;
                break;
            }
        }

        if ($hasFile) {
            // حالت ارسال فایل (multipart/form-data)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            // حالت معمولی (x-www-form-urlencoded)
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result === false || $httpCode !== 200) {
            return false;
        }

        $response = json_decode($result, true);
        return ($response && $response['ok']) ? $response : false;
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
    public function get_file_path($file_id) {
        return "https://tapi.bale.ai/file/bot{$this -> token}/{$file_id}";
    }
}