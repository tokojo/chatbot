<?php

# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Speech\SpeechClient;

print_r($_FILES); 
$size = $_FILES['audio_data']['size']; 
$input = $_FILES['audio_data']['tmp_name'];
$output = $_FILES['audio_data']['name'] . time() .".wav"; 
move_uploaded_file($input, $output);

$projectId = 'tactile-stack-223313';
$speech = new SpeechClient([
    'projectId' => $projectId,
    'languageCode' => 'ja-JP',
]);

# wav -> flac
$flac = "wave.flac";
$command = "ffmpeg -y -i $output $flac";
exec($command, $out, $res);
if($res) {
	echo "Error Command: $command, ";
	return;
}

# The audio file's encoding and sample rate
$options = [
    'encoding' => 'FLAC'
];

$results = $speech->recognize(fopen($flac, 'r'), $options);

$text = "";
if( !empty($results) ) {
   $text = $result->alternatives()[0]['transcript'];
}

if(strpos($text,'公園') !== false){
  
} elseif {
    
}
echo $text
?>