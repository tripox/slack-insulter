<?php

/**
 * @author Mathias Larsen <tripox@tripox.dk>
 * @link https://github.com/tripox/slack-insulter
 * @todo Add more insults
 */

require 'vendor/autoload.php';

// Array with insults
$insults = file('insults.txt');

// Pick a random insult
$insult = array_rand($insults);

// Find a 🖕  fuck you GIF on Giphy
$url = 'http://api.giphy.com/v1/gifs/translate?s=fuck+you&api_key=dc6zaTOxFJmzC&limit=1';
$image = json_decode(file_get_contents($url));
$imageurl = $image->data->images->original->url;

// Our JSON payload to Slack
$data = array(
  'response_type' => 'in_channel',
  'mrkdwn' => true,
  'text' => !empty($_POST['text']) ? '*Hey ' . '<' . $_POST['text'] . '>!*' : '*Hey!*',
  'attachments' => array(
    array(
      'image_url' => $imageurl,
      'pretext' => 'You\'ve been insulted with :hearts: by <@' . $_POST['user_name'] . '>',
      'text' => $insults[$insult] . ' :trollface:',
    ),
  ),
);

$client = new \GuzzleHttp\Client();
$request = $client->request('POST', $_POST['response_url'], ['body' => json_encode($data)]);
$request->send();
