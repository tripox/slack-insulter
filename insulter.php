<?php

/**
 * @author Mathias Larsen <tripox@tripox.dk>
 * @link https://github.com/tripox/slack-insulter
 * @todo Add more insults
 */

// Array with insults
$insults = array(
  "Shut up, you'll never be the man your mother is.",
  "You must have been born on a highway, because that's where most accidents happen.",
  "You're a failed abortion whose birth certificate is an apology from the condom factory.",
  "It looks like your face caught on fire and someone tried to put it out with a fork. :fork_and_knife:",
  "Your family tree is a cactus, because everybody on it is a prick. :cactus:",
  "You're so ugly Hello Kitty said goodbye to you.",
  "You're so ugly that when your mama dropped you off at school she got a fine for littering.",
  "If you were twice as smart, you'd still be stupid.",
  "Do you have to leave so soon? I was just about to poison the tea. :tea:",
  "You're so ugly when you popped out the doctor said 'aww, what a treasure!' and your mom said 'yeah, lets bury it!'",
  "We all sprang from apes, but you didn't spring far enough.",
  "I hear when you were a child your mother wanted to hire somebody to take care of you, but the mafia wanted too much.",
  "Out of 100,000 sperm, you were the fastest?",
  "I would ask how old you are, but I know you can't count that high.",
  "If you really want to know about mistakes, you should ask your parents.",
  "I could eat a bowl of alphabet soup and crap out a smarter comeback than what you just said. :hankey:",
  "When you were born, the police arrested your dad, the doctor slapped your mom, animal control euthanized your brother, and A&E made a documentary that saved your life.",
  "Your mamma so fat she has to wear 2 watches because she covers two time zones. :watch:",
  "You must be the arithmetic man; you add trouble, subtract pleasure, divide attention, and multiply ignorance.",
  "You're so fat the only letters of the alphabet you know are KFC.",
  "You're so fat you need cheat codes to play Wii Fit.",
  "With a face like yours, I wish I was blind.",
  "Why don't you check up on eBay and see if they have a life for sale. :moneybag:",
  "Is that your face? Or did your neck just throw up?",
  "The only positive thing about you is your HIV status.",
  "Here's 20 cents, call all your friends and give me back the change. :moneybag:",
  "Your mom is so stupid she tried to wake a sleeping bag.",
  "Your mom is so fat when she jumped in the ocean the whales :whale: :whale2: started singing 'We Are Family' :notes:",
  "Can I borrow your face? My arse is on holiday.",
  "Your mom is so fat, when she went to a doctor, she stepped on a scale and the doctor said \"Hey, that's my phone number.\"",
);

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

$str_data = json_encode($data);

$ch = curl_init($_POST['response_url']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_exec($ch);
curl_close($ch);

?>
