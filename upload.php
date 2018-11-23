<?php

# Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Speech\SpeechClient;

//print_r($_FILES); 
$size = $_FILES['audio_data']['size']; 
$input = $_FILES['audio_data']['tmp_name'];
$output = $_FILES['audio_data']['name'].".wav"; 
move_uploaded_file($input, $output);

# Your Google Cloud Platform project ID
$projectId = 'tactile-stack-223313';

# Instantiates a client
$speech = new SpeechClient([
    'projectId' => $projectId,
    'languageCode' => 'ja-JP',
]);

# wav -> flac
$flac = "wave.flac";
$command = "ffmpeg -i $output $flac";
exec($command, $out, $res);
if($res) {
	echo "Error Command: $command, ";
	return;
}

# The audio file's encoding and sample rate
$options = [
    'encoding' => 'FLAC',
    'sampleRateHertz' => 16000,
];

$results = $speech->recognize(fopen($flac, 'r'), $options);

foreach ($results as $result) {
    echo 'Transcription: ' . $result->alternatives()[0]['transcript'] . PHP_EOL;
}

print_r($results);
?>