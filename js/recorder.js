let mediaRecorder;
let audioChunks = [];
let countdownInterval;

async function startRecording() {

    if (!navigator.mediaDevices) {
        alert("Media Devices not supported!");
        return;
    }

    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

        mediaRecorder = new MediaRecorder(stream);
        audioChunks = [];

        mediaRecorder.start();

        let secondsLeft = 8;
        document.getElementById("status").innerText =
            "Listening... " + secondsLeft + "s";

        // Countdown timer
        countdownInterval = setInterval(() => {
            secondsLeft--;
            document.getElementById("status").innerText =
                "Listening... " + secondsLeft + "s";

            if (secondsLeft <= 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);

        mediaRecorder.ondataavailable = event => {
            audioChunks.push(event.data);
        };

        // Stop after 8 seconds
        setTimeout(() => {
            mediaRecorder.stop();
            document.getElementById("status").innerText = "Processing...";
        }, 8000);

        mediaRecorder.onstop = () => {
            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
            sendToServer(audioBlob);
        };

    } catch (error) {
        alert("Microphone error!");
        console.error(error);
    }
}

function sendToServer(audioBlob) {
    const formData = new FormData();
    formData.append("audio", audioBlob, "recording.webm");

    fetch("recognize.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        if (data.error) {
            document.getElementById("result").innerHTML =
                "<p style='color:red'>" + data.error + "</p>";
            document.getElementById("status").innerText = "";
            return;
        }

        document.getElementById("status").innerText = "Done ✅";

        document.getElementById("result").innerHTML = `
            <h2>${data.artist} - ${data.title}</h2>
            <iframe width="400" height="300"
                src="https://www.youtube.com/embed/${data.youtube_id}"
                frameborder="0"
                allowfullscreen>
            </iframe>
        `;
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error sending audio.");
    });
}