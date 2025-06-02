<?php
class Condition {
    public $conditions ;
    public $path;
    public $file ;
    public function __construct($path = __DIR__.'/conditions/' , $file = 'condition.json'){
        if(!file_exists($path)){
            file_put_contents($path, '{}');
        }
        $this -> conditions = json_decode(file_get_contents($path.$file), true);
        $this -> path = $path;
        $this -> file = $file;
    }
    public function save_changes(){
        return file_put_contents($this -> path . $this -> file, json_encode($this->conditions, JSON_PRETTY_PRINT));
    }
    public function create_condition($condition , $data , $function , $regex = false){
        if(!function_exists($function)){
            die("Function '$function' not exists in conditions");
        }else{
            $reflection = new ReflectionFunction($function);
            $filename = $reflection->getFileName();
            $startLine = $reflection->getStartLine();
            $endLine = $reflection->getEndLine();
            $sourceCode = file($filename);
            $functionCode = implode('', array_slice($sourceCode, $startLine - 1, $endLine - $startLine + 1));
            $uniq = uniqid()."_".time()."_".random_int(0,10000000);
            $functionCode = str_replace($function , "func_".$uniq , $functionCode);
            file_put_contents($this -> path.'functions/'.$uniq.".php", PHP_EOL . $functionCode);
            $this -> conditions[$condition][] =[
                "data" => $data,
                "function" => "func_".$uniq ,
                "uniq" => $uniq,
                "regex" => $regex
            ];
            $this -> save_changes();

        }
        return true;
    }
    public function OnTextMessage( $text  , $callback , $regex = false ){
        if($text == true) {$text = "/.*?/s";$regex = true;}
        return $this -> create_condition("OnText" , [
            'equal' => $text,
        ] , $callback , $regex);
    }
    public function OnPhotoMessage($callback  ){
        return $this -> create_condition("OnPhoto" , [] , $callback , null);
    }
    public function OnDocumentMessage($callback  ){
        return $this -> create_condition("OnDocument" , [] , $callback , null);
    }
    public function OnVideoMessage($callback  ){
        return $this -> create_condition("OnVideo" , [] , $callback , null);
    }
    public function OnVoiceMessage($callback  ){
        return $this -> create_condition("OnVoice" , [] , $callback , null);
    }
    public function OnAudioMessage($callback  ){
        return $this -> create_condition("OnAudio" , [] , $callback , null);
    }
    public function OnEveryMessage($callback  ){
        return $this -> create_condition("AllMessage" , [] , $callback , null);
    }
    public function reset_conditions(){

        foreach($this -> conditions as $key => $condition){
            foreach($condition as $function){
                unlink($this -> path.'functions/'.$function['uniq'].".php");
                echo "A condition has been deleted\n";
            }
            unset($this -> conditions[$key]);

        }
        echo 'Conditions have been reset';
        $this -> save_changes();
    }
    public function dump(){
        return $this -> conditions;
    }


}