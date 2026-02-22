function searchSong() {

    let query = document.getElementById("searchInput").value;

    if (query.trim() === "") {
        alert("Enter a song name");
        return;
    }

    fetch("search.php?query=" + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {

            if (data.error) {
                document.getElementById("result").innerHTML =
                    "<p style='color:red'>" + data.error + "</p>";
                return;
            }

            document.getElementById("result").innerHTML = `
                <h3>${data.title}</h3>
                <iframe width="400" height="250"
                    src="https://www.youtube.com/embed/${data.youtube_id}"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            `;
        })
        .catch(error => {
            console.error(error);
            alert("Search failed");
        });
}