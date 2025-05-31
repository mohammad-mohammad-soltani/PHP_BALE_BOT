<?php
require "PHPBaleBot/Client.php";
require "PHPBaleBot/Stream.php";
require "PHPBaleBot/Message.php";
require "PHPBaleBot/InlineGen.php";
require "PHPBaleBot/Condition.php";
require "PHPBaleBot/MessageData.php";
$stream = new Stream("YOUR_TOKEN_IS_HERE");
$Message = $stream -> message;
$stream->connect(10);


//$condition = new Condition();
//function say($update){
//    (new Message() ) -> sendMessage($update['message']['text'], $update);
//}
//$condition -> OnTextMessage('/^[\s\S]*$/' , 'say' , true);
////$condition -> reset_conditions();