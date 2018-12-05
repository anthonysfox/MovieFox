document.getElementById('submit').addEventListener('click', showGenre);
function showGenre(e) {
    e.preventDefault();

    var option = document.getElementById('option').value;
    var year = document.getElementById('year').value;
    var submitData = document.getElementById('submitData').value;
    var params = "option="+option+"&year="+year+"&willSubmit="+submitData;

    var xhr = new XMLHttpRequest();

    xhr.open('POST', 'apiConnection.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('txtHint').innerHTML = this.responseText;
    }

    xhr.send(params);
}