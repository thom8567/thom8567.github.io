<?php

session_start();

function formatQuestionNumbers(string $question){
    $question = preg_replace('/(?<!\ )[A-Z]/', ' $0', $question);
    $question = preg_replace('/(?<!\ )\d{1,2}/', ' $0', $question);
    $question = ucwords($question);
    return $question;
}

function printError(string $question, string $section, $answers){
    if ( !empty($answers[$section][$question]) ){
        echo "<p><b>".formatQuestionNumbers($question)."</b> - ". checkAnswer($question, $section, $answers) ."</p>";
    }
}

function checkAnswer($question, $section, $answers){
    $answer = $answers[$section][$question];
    if ( is_array($answer) ){
        if ( isset($answer['range']) && isset($answer['number']) ){
            return $answer['range'] + $answer['number'];
        }
        return implode( ', ', $answer );
    }
    return (string) $answer;
}

function checkIfIntegers($array, string $predicate){
    return array_filter($array, $predicate) === $array;
}

function redirect(){
    header( 'Location: http://localhost:8000' );
    exit();
}

if ( !empty($_SESSION['answers']) ){
    $answers = $_SESSION['answers'];
    unset( $_SESSION['answers'] );
} else {
    redirect();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome!</title>

    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/assets/favicon.ico" type="image/x-icon">

    <?php
        require __DIR__ . '/includes/cdn-links.php';
    ?>

</head>
<body>

    <div class="container form-colour">

        <?php

            $userAnswers = $answers['user'];
            $questionAnswers = $answers['question'];
            $userKeys = array_keys($userAnswers);
            $questionKeys = array_keys($questionAnswers);

            foreach($userKeys as $userQuestion){
                printError($userQuestion, 'user', $answers);
            }
            foreach($questionKeys as $question){
                printError($question, 'question', $answers);
            }

        ?>

    </div>




</body>
</html>
