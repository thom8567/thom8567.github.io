<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome!</title>

    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/assets/favicon.ico" type="image/x-icon">

    <?php
        require __DIR__ . '/includes/cdn-links.php';
        require __DIR__ . '/includes/mysqli_connect.php';
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    ?>

</head>
<body>

    <?php

        $stmt = $mysqli -> prepare( "SELECT * FROM quiz_data" );
        $stmt -> execute();
        $result = $stmt -> get_result();

        if ( $result -> num_rows === 0 ){
            exit ( 'No rows' );
        }

        while ( $row = $result -> fetch_assoc() ){
            $ids[] = $row['id'];
            $names[] = $row['full_name'];
            $emails[] = $row['email_address'];
            $phoneNumbers[] = $row['phone_number'];
            $question1Ans[] = $row['question1'];
            $question2Ans[] = $row['question2'];
            $question3Ans[] = $row['question3'];
            $question4Ans[] = $row['question4'];
            $question5Ans[] = $row['question5'];
            $question6Ans[] = $row['question6'];
            $question7Ans[] = $row['question7'];
            $question8Ans[] = $row['question8'];
            $question9Ans[] = $row['question9'];
            $question10Ans[] = $row['question10'];
            $question11Ans[] = $row['question11'];
        }

        var_dump($ids, $names, $emails, $phoneNumbers, $question1Ans, $question2Ans, $question3Ans, $question4Ans,
                 $question5Ans, $question6Ans, $question7Ans, $question8Ans, $question9Ans, $question10Ans, $question11Ans);

        $stmt -> close();

    ?>

</body>
</html>
