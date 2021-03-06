<html>
<head>
    <link rel="stylesheet" type="text/css" href="relistenForm.css">
</head>

<?php

// create a new cURL resource
$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://relistenapi.alecgorge.com/api/v2/artists/");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Will return the response, if false it print the response

$result_json = curl_exec($ch); // execute curl call
$decodedJson = json_decode($result_json); // decode into array

foreach ($decodedJson as $artist) {
    $artist_name = $artist->name;
    $artist_slug = $artist->slug;
    $artist_showCount = $artist->show_count;
    $artist_musicbrainz_id = $artist->musicbrainz_id;
    $artist_sourceCount = $artist->source_count;

    if ($artist_slug != $_GET['band']) {
        continue;
    }

    print("<p>Band: $artist_name     Total Show Count Available: $artist_showCount</p>");

    curl_setopt($ch, CURLOPT_URL, "https://relistenapi.alecgorge.com/api/v2/artists/$artist_slug/years");
    $result_json = curl_exec($ch); // execute curl call
    $decodedJson = json_decode($result_json); // decode into array

    foreach ($decodedJson as $showSYear) {
        $showYear = $showSYear->year;
        if ($showYear != $_GET['year']) {
            continue;
        }

        curl_setopt($ch, CURLOPT_URL, "https://relistenapi.alecgorge.com/api/v2/artists/$artist_slug/years/$showYear");
        $result_json = curl_exec($ch); // execute curl call
        $decodedJson = json_decode($result_json); // decode into array
        $showCount = $showSYear->show_count;
        print("<p>Show Year: $showYear Show Count For This Year: $showCount</p>");

        print("<table>");

        // Process Each Show in Year
        foreach ($decodedJson->shows as $show) {
            $showDate = $show->display_date;
            $showDateS[] = $showDate;
            $venueName = $show->venue->name;


            curl_setopt($ch, CURLOPT_URL, "https://relistenapi.alecgorge.com/api/v2/artists/$artist_slug/years/$showYear/$show->display_date");
            $result_json = curl_exec($ch); // execute curl call
            $decodedJson = json_decode($result_json); // decode into array
            // Search Show for target track
            $foundFirstSetInShow = FALSE;
            foreach ($decodedJson->sources as $source) {
                $numberOfSets = sizeof($source->sets);
                if ($numberOfSets != 1) {
                    print("Boogie, Boogie");
                    exit(666);
                }
                foreach ($source->sets as $item) {
                    // Search for Target Track
                    foreach ($item->tracks as $item) {
                        $trackSlug = $item->slug;
                        $song2slug = preg_replace('!\s+!', '-', strtolower($_GET['songTitle'])); // convert song title to lower-case-slug

                        if (!strcmp($trackSlug, $song2slug)) { // found target
                            if (!$foundFirstSetInShow) {
                                print("<tr><td>");
                                print("<p>Show Date: $showDate Show Venue: $venueName</p>");
                                print("</td></tr>");
                            }
                            $foundFirstSetInShow = TRUE;
                            $trackTitle = $item->title;
                            $mp3 = $item->mp3_url;
                            print("<tr><td>");
                            print("<audio controls><source src=$mp3></audio><br>");
                            print("</td></tr>");

                            break; // found/printed target -- get out!
                        }
                    }

                }

            }
        }
    }
    print("</table>"); //????

}

curl_close($ch);  // close cURL resource, and free up system resources

?>
</html>
