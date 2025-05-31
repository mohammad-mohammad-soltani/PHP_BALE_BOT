<?php
class InlineGen {
    public $buttons ;
    public $type;
    public function __construct($type){
        $this -> type = $type;
        $this -> buttons['reply_markup'] = [
            'inline_keyboard' => [],
            'keyboard' => []
        ];
    }
    public function inline_keyboard($buttons){
        $this->buttons['reply_markup']['inline_keyboard'] = $buttons;
    }
    public function keyboard($buttons){
        $this->buttons['reply_markup']['keyboard'] = $buttons;
    }
    public function buttons(){
        $this -> buttons['reply_markup'] = json_encode($this->buttons['reply_markup']);
        return $this->buttons;
    }
}