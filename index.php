<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Soundify</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background: linear-gradient(135deg, #1e1e2f, #121212);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: #1f1f1f;
            padding: 40px;
            border-radius: 15px;
            width: 450px;
        }

        input {
            padding: 10px;
            width: 70%;
            border-radius: 20px;
            border: none;
            outline: none;
        }

        button {
            padding: 10px 20px;
            background: #1db954;
            border: none;
            border-radius: 20px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #17a74a;
        }

        #result {
            margin-top: 20px;
        }

        iframe {
            margin-top: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>🎧 Soundify</h1>

    <!-- Manual Search -->
    <input type="text" id="searchInput" placeholder="Search any song...">
    <br>
    <button onclick="searchSong()">Search</button>

    <hr style="margin:25px 0; border:1px solid #333;">

    <!-- Recognition -->
    <button onclick="startRecording()">🎙 Recognize Music</button>

    <div id="status"></div>
    <div id="result"></div>

</div>

<script src="js/recorder.js"></script>
<script src="js/search.js"></script>

</body>
</html>