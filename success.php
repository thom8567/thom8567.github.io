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

        function formatQuestionNumbers(string $question){

            $question = preg_replace('/(?<!\ )[A-Z]/', ' $0', $question);
            $question = preg_replace('/(?<!\ )\d{1,2}/', ' $0', $question);
            $question = ucwords($question);
            return $question;
        }

        function printError(string $question, string $section, $errors){
            if ( !empty($errors[$section][$question]) ){
                echo "<p><b>".formatQuestionNumbers($question)."</b> - ".$errors[$section][$question]."</p>";
            }
        }


        $answers = $_SESSION['answers'];



    ?>

</body>
</html>
