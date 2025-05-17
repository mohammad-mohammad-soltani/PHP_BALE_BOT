<?php
class Message Extends Client
{
    public $condition;
    public function handle_message($update) {
        if(isset($update['message']['text'])){
            $this -> condition = new Condition();
            $conditions = $this -> condition -> dump();
            foreach($conditions['OnText'] as $entity){
                if($entity['regex'] && preg_match( $entity["data"]['equal'] , $update['message']['text']) ){
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

}