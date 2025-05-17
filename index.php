<?php
require "PHPBaleBot/Client.php";
require "PHPBaleBot/Stream.php";
require "PHPBaleBot/Message.php";
require "PHPBaleBot/Condition.php";
$stream = new Stream("707252215:cMk9yNKjyYV3vw5KhfadgqbEtFl4fDhDbMVrOtNe");
$stream->connect(100);
//$condition = new Condition();
//$condition -> reset_conditions();