<?php
include("includes/db.php");

$apiToken = "ce64a586f2d9ab9f920ce64adf0efa52";
$youtubeApiKey = "AIzaSyAKlBl6vBZtgxNLgukHLwpa7LQZqtg6Hzw";

if (!isset($_FILES['audio'])) {
    echo json_encode(["error" => "No audio received."]);
    exit;
}

$audioPath = "uploads/" . time() . ".webm";
move_uploaded_file($_FILES['audio']['tmp_name'], $audioPath);

/* ----------- SEND TO AudD ----------- */

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.audd.io/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'api_token' => $apiToken,
        'file' => new CURLFile($audioPath),
        'return' => 'apple_music,spotify'
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (!isset($result['result'])) {
    echo json_encode(["error" => "Song not recognized. Try again."]);
    exit;
}

$title  = $result['result']['title'] ?? "";
$artist = $result['result']['artist'] ?? "";

$searchQuery = $artist . " " . $title . " official audio";

/* ----------- SEARCH YOUTUBE ----------- */

$searchUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=1&q="
    . urlencode($searchQuery)
    . "&key=" . $youtubeApiKey;

$youtubeResponse = file_get_contents($searchUrl);
$youtubeData = json_decode($youtubeResponse, true);

if (!isset($youtubeData['items'][0]['id']['videoId'])) {
    echo json_encode(["error" => "YouTube video not found."]);
    exit;
}

$videoId = $youtubeData['items'][0]['id']['videoId'];

/* ----------- SAVE TO DATABASE ----------- */

$stmt = $conn->prepare("INSERT INTO history (song_title, youtube_id) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $videoId);
$stmt->execute();
$stmt->close();

/* ----------- RETURN RESULT ----------- */

echo json_encode([
    "title" => $title,
    "artist" => $artist,
    "youtube_id" => $videoId
]);