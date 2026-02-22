<?php

$youtubeApiKey = "AIzaSyAKlBl6vBZtgxNLgukHLwpa7LQZqtg6Hzw";

if (!isset($_GET['query'])) {
    echo json_encode(["error" => "No search query"]);
    exit;
}

$query = $_GET['query'];

$searchUrl = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=1&q="
    . urlencode($query . " official audio")
    . "&key=" . $youtubeApiKey;

$response = file_get_contents($searchUrl);
$data = json_decode($response, true);

if (!isset($data['items'][0]['id']['videoId'])) {
    echo json_encode(["error" => "No results found"]);
    exit;
}

$videoId = $data['items'][0]['id']['videoId'];
$title = $data['items'][0]['snippet']['title'];

echo json_encode([
    "title" => $title,
    "youtube_id" => $videoId
]);