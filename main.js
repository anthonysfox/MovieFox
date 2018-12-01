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
            document.getElementById('txtHint').innerHTML = this.responseText;
        }

        xhr.send(params);
}

document.getElementById('postForm').addEventListener('click', showGenre);
function showGenre(e) {
    e.preventDefault();

    var option = document.getElementById('option').value;
    var year = document.getElementById('year').value;
    var submitData = document.getElementById('submitData').value;
    var params = "option="+option+"&year="+year+"&willSubmit="+submitData;

    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'APIform.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('txtHint').innerHTML = this.responseText;
    }

    xhr.send(params);
}