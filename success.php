<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome!</title>

    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/assets/favicon.ico" type="image/x-icon">

</head>
<body>

    <?php

        $errors = $_SESSION['errors'];

        $questionKeys = array_keys($errors);

        foreach ( $questionKeys as $questionNumber ){
            $response = $errors[$questionNumber];
            $questionNumber = preg_replace('/(?<!\ )[A-Z]/', ' $0', $questionNumber);

            $questionNumber = preg_replace('/(?<!\ )\d{1,2}/', ' $0', $questionNumber);

            $questionNumber = ucwords($questionNumber);

            echo "<div> <b>$questionNumber</b> - <br/> $response <hr/> </div>";
        }

    ?>

</body>
</html>
