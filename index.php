<?php include('inc/header.php'); ?>
    <header class="background">
        <div class="content">
            <h1>Welcome to MovieFox!</h1>
            <p>Need to see the top movies from the past few years? You've come to the right place!</p>
        </div>
    </header>
    <div class="container">
        <div class="select-form">
            <form>
                <select id="option">
                <option value="">Select a Genre:</option>
                <option value="1">Horror</option>
                <option value="3">Action</option>
                <option value="4">Family</option>
                <option value="6">Comedy</option>
                <option value="8">Drama</option>
                <option value="9">Animation</option>
                </select>

                <select id="year">
                    <option value="">Select a Genre:</option>
                    <option value="4">2013</option>
                    <option value="5">2014</option>
                    <option value="6">2015</option>
                    <option value="7">2016</option>
                    <option value="8">2017</option>
                    <option value="9">2018</option>
                </select>
                <input id="movieDisplay" type="submit" value="Submit">
            </form>
        </div>
        <div class="movies" id="txtHint"><b>Movies will be listed here...</b></div>

<?php include('inc/footer.php'); ?>