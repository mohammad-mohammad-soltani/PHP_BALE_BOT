# Start Client 
___
## live stream mode
```php
<?php
$stream = new Stream($token);
$stream -> connect($sleep = 100ms); //$sleep is optional
```

# Message Functions
___
# Send Message
```php 
(new Message()) -> sendMessage($text , $chatID , $other_options);      
```
-  text:Update array OR String
-  chatID:Update array OR String
-  other_options:Array
# Copy Message
```php 
(new Message()) -> copyMessage($from_chat_id , $messageID , $chatID);      
```
-  from_chat_id:Update array OR String
-  MessageID:Update array OR String
-  ChatID:Update array OR String


# Send Audio
```php 
(new Message()) -> sendAudio($audio , $chatID , $other_options );      
```
-  audio:Update array , Link , FileID , File Path 
-  chatID:Update array OR String
-  other_options:Array

# Send Voice
```php 
(new Message()) -> sendVoice($voice , $chatID , $other_options );      
```
-  voice:Update array , Link , FileID , File Path 
-  chatID:Update array OR String
-  other_options:Array

# Send Video
```php 
(new Message()) -> sendVideo($video , $chatID , $other_options );      
```
-  video:Update array , Link , FileID , File Path 
-  chatID:Update array OR String
-  other_options:Array

# Send Document
```php 
(new Message()) -> sendDocument($documetn , $chatID , $other_options );      
```
-  document:Update array , Link , FileID , File Path 
-  chatID:Update array OR String
-  other_options:Array

# Send Photo
```php 
(new Message()) -> sendPhoto($documetn , $chatID , $other_options );      
```
-  photo:Update array , Link , FileID , File Path 
-  chatID:Update array OR String
-  other_options:Array

### Condition Functions
___
# Reset All Conditions
```php
<?php
$condition = new Condition();
$condition -> reset_conditions(); 
```
# Add New Every Message Condition
```php
<?php
$condition = new Condition();
$condition -> OnEveryMessage($callback); 
```
## Example
```php
<?php
$condition = new Condition();
function every_message($update) {
    (new Message()) -> SendMessage('new message' , $update);
} 
$condition -> OnEveryMessage('every_message'); 
```
# Add New Text Condition 
```php
<?php
$condition = new Condition();
$condition -> OnTextMessage($text , $callback , $regex = false); 
```
## Examples

```php
<?php
$condition = new Condition();
function greet($update) {
    (new Message()) -> SendMessage('hello' , $update);
}
$condition -> OnTextMessage('hello' , 'greet' );
```


```php
<?php
$condition = new Condition();
function greet($update) {
    (new Message()) -> SendMessage($update , $update); // Resend the user text message
}
$condition -> OnTextMessage(true , 'greet' ); // It works on any text message 
```


```php
<?php
$condition = new Condition();
function phone_number($update) {
    (new Message()) -> SendMessage('You Sent a phone number !' , $update); // Resend the user text message
}
$condition -> OnTextMessage('^(\\+98|0)?9\\d{9}$' , 'phone_number' , true ); // regex for +98xxxxxxxxxx pattern 
```

# Add New Photo Condition 
```php
<?php
$condition = new Condition();
$condition -> OnPhotoMessage($callback);
```

## Example 
```php
<?php
$condition = new Condition();
function photo_func($update) {
    (new Message()) -> SendPhoto($update , $update); // Resend photo
} 
$condition -> OnPhotoMessage('photo_func');
```

# Add New Audio Condition 
```php
<?php
$condition = new Condition();
$condition -> OnAudioMessage($callback);
```

## Example 
```php
<?php
$condition = new Condition();
function audio_func($update) {
    (new Message()) -> SendAudio($update , $update); // Resend audio
} 
$condition -> OnAudioMessage('audio_func');
```

# Add New Voice Condition 
```php
<?php
$condition = new Condition();
$condition -> OnVoiveMessage($callback);
```

## Example 
```php
<?php
$condition = new Condition();
function voice_func($update) {
    (new Message()) -> SendVoice($update , $update); // Resend voice
} 
$condition -> OnVoiceMessage('voice_func');
```

# Add New Video Condition 
```php
<?php
$condition = new Condition();
$condition -> OnVideoMessage($callback);
```

## Example 
```php
<?php
$condition = new Condition();
function video_func($update) {
    (new Message()) -> SendVideo($update , $update); // Resend video
} 
$condition -> OnvideoMessage('video_func');
```

# Add New Document Condition 
```php
<?php
$condition = new Condition();
$condition -> OnDocumentMessage($callback);
```

## Example 
```php
<?php
$condition = new Condition();
function document_func($update) {
    (new Message()) -> SendDocument($update , $update); // Resend video
} 
$condition -> OnDocumentMessage('document_func');
```

# Some Real Examples
___

# Mirror Bot
1- Run this code to create conditions
```php
<?php
require 'PHPBaleBot/loader.php';
$condition = new Condition();
function mirror($update) {
    (new Message()) -> copyMessage($update , $updare , $update);
} 
$condition -> OnEveryMessage('mirror');
```
2- run this code to run bot 
```php
require 'PHPBaleBot/loader.php';
<?php
$stream = new Stream($token);
$stream -> connect(10); //10 for very fast bot

```

