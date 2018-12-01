<?php include('inc/header.php'); ?>
    <h1> The purpose of this page is to update the current top movies</h1>
    <form id="postForm">
        <select id="option">
            <option value="">Pick a Genre</option>
            <option value="28">Action</option>
            <option value="10751">Family</option>
            <option value="16">Animation</option>
            <option value="35">Comedy</option>
            <option value="27">Horror</option>
            <option value="18">Drama</option>
        </select>
        <select id="year">
            <option value="">Pick a Year</option>
            <option value="2010">2010</option>
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
        </select>
        <input type="submit" onsubmit="showGenre()">
        </div>
        <br>
        <br>
        <select id="submitData">
            <option value="">Submit To Database?</option>
            <option value="true">Yes</option>
            <option value="false">No</option>
        </select>
        <input type="submit" value="Submit To Database" onsubmit="insertData()">
    </form>

    <div id="txtHint"></div>
    <div id="submitSuccess"></div>
<?php include('inc/footer.php');