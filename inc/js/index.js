document.getElementById('movieDisplay').addEventListener('click', showMovies);
function showMovies(e) {
        e.preventDefault();

        var genre = document.getElementById('option').value;
        var year = document.getElementById('year').value;
        var params = "genre="+genre+"&year="+year;

        var xhr = new XMLHttpRequest();

        xhr.open('POST', "getMovies.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            document.getElementById('movieList').innerHTML = this.responseText;
        }

        xhr.send(params);
}