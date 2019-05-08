<?php

    session_start();

    function validate($answers, $key, array $ruleSet){
        try {
            if ( isset($ruleSet['required']) && $ruleSet['required'] ){
                assertFilledOut( $answers, $key );
            }
            if ( isset($ruleSet['answerNeeded']) && $ruleSet['answerNeeded'] ){
                assertAnswered( $answers, $key );
            }
            if ( isset($ruleSet['sliderInput']) && $ruleSet['sliderInput'] ){
                assertCheckCalculation( $answers, $key, $ruleSet['correctChoices'] );
            }
            if ( isset($ruleSet['correctChoices']) && is_array($ruleSet['correctChoices']) ){
                assertCheckAnswer($answers, $key, $ruleSet['correctChoices'] );
            }
        } catch ( \Exception $exception ) {
            return $exception -> getMessage();
        }
    }

    //Check if question is answered
    function assertFilledOut( array $answers, $key){
        //Get question from answers array and return true/false depending on whether set or not
        if ( !isset($answers[$key]) ){
            throw new \Exception('Required field has not been filled in' );
        } else {
            if ( strpos($key, 'Address') ){
                if ( !filter_var($answers[$key], FILTER_VALIDATE_EMAIL) ){
                    throw new \Exception( 'Not valid' );
                } else {
                    throw new \Exception( $answers[$key] );
                }
            } else if ( strpos($key, 'Name') ){
                if ( !preg_match("/^[a-z ,.\'-]+$/i", $answers[$key]) ){
                    throw new \Exception( 'Not valid' );
                } else {
                    throw new \Exception( $answers[$key] );
                }
            } else if ( strpos($key, 'Number') ){
                if ( !phoneNumberValidation($answers[$key]) ){
                    throw new \Exception( 'Not valid' );
                } else {
                    throw new \Exception( $answers[$key] );
                }
            }
        }
    }

    function assertAnswered ( array $answers, $key ){
        if ( empty($answers[$key]) ){
            throw new \Exception('Question has not been answered' );
        }
    }

    function assertCheckAnswer ( array $answers, $key, array $choices ){
        //Check answer and perform different validation based on type
        if ( is_numeric($answers[$key]) ){
            $answer = (int)($answers[$key]);
            if ( $answer !== $choices[0] ){
                throw new \Exception( 'Incorrect!' );
            }
        } else if ( is_array($answers[$key]) ){
            if ( $answers[$key] !== $choices ){
                throw new \Exception( 'Incorrect!' );
            }
        } else if ( is_string($answers[$key]) ) {
            if (strpos($answers[$key], $choices[0]) == false) {
                throw new \Exception('Incorrect!');
            }
        } else if ( $answers[$key] === '' ){
            throw new \Exception( 'Good choice!' );
        } else {
            throw new \Exception( 'Unknown type' );
        }
    }

    function assertCheckCalculation ( array $answers, $key, $choices ){
        if ( empty($answers[$key]) ){
            throw new \Exception( 'Question has not been answered' );
        } else {
            $range = (int)($answers[$key]['range'] ?? 0);
            $number = (int)($answers[$key]['number'] ?? 0);
            $result = $range + $number;
            if ( $result !== $choices[0] ){
                throw new \Exception( 'Incorrect!' );
            }
        }
    }

    function phoneNumberValidation($phoneNumber){
        //Change for UK numbers only
        if ( preg_match('/^0[1-9][0-9]{9}$/', $phoneNumber) ){
            return true;
        } else {
            return false;
        }
    }

    function redirect(string $url){
        header( 'Location: http://localhost:8000/' . $url );
        exit();
    }

    //Making sure that POST is correct and is an array
    $answers = ( array ) ( $_POST ?? [] );

    //Declaring a score keeping variable
    $quizScore = 0;

    $rules = [
        'fullName' => [
            'required' => true,
            'pattern' => "/^[a-z ,.\'-]+$/i",
        ],
        'emailAddress' => [
            'required' => true,
            'email'    => true,
        ],
        'phoneNumber'  => [
            'required'    => true,
            'phoneNumber' => true,
        ],
        'question1' => [
            'correctChoices' => ['Stars'],
            'answerNeeded'  => false,
        ],
        'question2' => [
            'correctChoices' => ['Tiger'],
            'answerNeeded'  => true,
        ],
        'question3' => [
            'correctChoices' => ['Audi', 'Lamborghini'],
            'answerNeeded'   => true,
        ],
        'question4' => [
            'correctChoices' => ['Rome'],
            'answerNeeded'   => true,
        ],
        'question5' => [
            'correctChoices' => ['Arctic', 'Antarctic'],
            'answerNeeded'   => true,
        ],
        'question6' => [
            'correctChoices' => ['Whitehouse'],
            'answerNeeded'   => true,
        ],
        'question7' => [
            'correctChoices' => ['George Washington'],
            'answerNeeded'   => true,
        ],
        'question8' => [
            'correctChoices' => [400],
            'answerNeeded'   => true,
        ],
        'question9' => [
            'answerNeeded' => true
        ],
        'question10' => [
            'correctChoices' => [150],
            'sliderInput'   => true,
        ],
        'question11' => [
            'correctChoices' => [600],
            'sliderInput'   => true,
        ]
    ];

    $errors = [];

    foreach ( $rules as $key => $rule ) {
        $errors[$key] = validate($answers, $key, $rule);
    }

    foreach ( $errors as $value ){
        if ( $value === 'Incorrect!' || $value === 'Question has not been answered' || $value === 'Unknown type'
             || $value === 'Not valid' || $value === 'Required field has not been filled in' ){
            $_SESSION['errors'] = $errors;
            redirect('index.php');
        } else {
            $_SESSION['errors'] = $errors;
            redirect('success.php');
        }
    }

//    Pretty sure these are now redundant
//
//    $questionKeys = array_keys($errors);
//
//    foreach ( $questionKeys as $questionNumber ){
//        $response = $errors[$questionNumber];
//        $questionNumber = preg_replace('/(?<!\ )[A-Z]/', ' $0', $questionNumber);
//
//        $questionNumber = preg_replace('/(?<!\ )\d{1,2}/', ' $0', $questionNumber);
//
//        $questionNumber = ucwords($questionNumber);
//    }

?>