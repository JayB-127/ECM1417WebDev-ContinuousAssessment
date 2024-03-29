<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/leaderboard.css">
        <title>LEADERBOARD</title>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <?php include("navbar.php"); ?>
        <div id="main">
            <?php
            if (isset($_POST["submit"])) { //when the user submits their score
                if (empty($_COOKIE["username"])) {
                    $username = "Guest";
                } else {
                    $username = $_COOKIE["username"];
                }
                //create the string of all the scores that will be written to leaderboard.csv
                $round1 = $_POST["round1score"];
                $round2 = $_POST["round2score"];
                $round3 = $_POST["round3score"];
                $score = $_POST["score"];
                $msg = $score . ", " . $round1 . ", " . $round2 . ", " . $round3 . ", " . $username . "\n";

                //create array of current lines in the file
                $content = file_get_contents("../data/leaderboard.csv");
                $lines = explode("\n", $content);

                //check if the user already has scores saved in leaderboard.csv (by checking presence of their name)
                $containsName = false;
                foreach ($lines as $line) {
                    $name = explode(", ", $line)[4];
                    //if they already have scores, replace the line of their scores with their new scores
                    if ($name == $username) {
                        $msg = $score . ", " . $round1 . ", " . $round2 . ", " . $round3 . ", " . $username;
                        $updatedContent = str_replace($line, $msg, $content);
                        file_put_contents("../data/leaderboard.csv", $updatedContent);
                        $containsName = true;
                        break;
                    }
                }

                //if they don't already have scores, add a new line of their scores
                if ($containsName === false) {
                    $updatedContent = $content . $msg;
                    file_put_contents("../data/leaderboard.csv", $updatedContent);
                }
            }
            ?>
            <div id="leaderboard">
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Round 1</th>
                        <th>Round 2</th>
                        <th>Round 3</th>
                        <th>Total Score</th>
                    </tr>
                    <?php
                    $file = fopen("../data/leaderboard.csv", "r");

                    //sort the lines of leaderboard.csv in descending order of total score
                    $content = file_get_contents("../data/leaderboard.csv");
                    $lines = explode("\n", $content);
                    arsort($lines);
                    $updatedContent = implode("\n", $lines);
                    file_put_contents("../data/leaderboard.csv", $updatedContent);

                    //display the parts of each line in rows of the leaderboard table
                    while (($line = fgets($file)) !== false) {
                        $strings = explode(", ", $line);
                        echo "<tr><td>$strings[4]</td><td>$strings[1]</td><td>$strings[2]</td><td>$strings[3]</td><td>$strings[0]</td><tr>";
                    }
                    fclose($file);
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>