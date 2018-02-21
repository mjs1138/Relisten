<html>
<head>
    <title>PHP Test</title>
    <link rel="stylesheet" type="text/css" href="relistenForm.css">
</head>

<body>

<div class="container">
    <!--    <form action="/action_page.php"> -->
    <form action="/getSongs.php">
        <label for="songTitle">Song Title</label>
        <input type="text" id="songTitle" name="songTitle" placeholder="Song Title.." value="dark star">

        <label for="year">Year</label>
        <input type="text" id="year" name="year" placeholder="Year.." value="1969">

        <label for="band">Band</label>
        <select id="band" name="band">
            <option value="grateful-dead">Grateful Dead</option>
            <option value="dead-and-company">Dead & Company</option>
            <option value="dark-star-orchestra">Dark Star Orchestra</option>
        </select>
        <div id="boogie">
            <input type="radio" id="sourceChoice_1"
                   name="singleSource" value="TRUE" checked>
            <label for="sourceChoice_1">Only One Source</label>

            <input type="radio" id="sourceChoice_2"
                   name="singleSource" value="FALSE">
            <label for="sourceChoice_2">All Sources</label>
        </div>


        <input type="submit" value="Submit">

    </form>
</div>

</body>
</html>

