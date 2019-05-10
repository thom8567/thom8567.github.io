<?php

    session_start();

    function assertRequired( array $answers, $key ){
        if ( empty($answers['user'][$key]) ){
            throw new \Exception( 'Required field has not been filled in' );
        }
    }

    function assertType( array $answers, $key, $type){
        if ( $type === 'string' ){
            assertValidName( $answers['user'][$key] );
        }
        if ( $type === 'email' ){
            assertValidEmail( $answers['user'][$key] );
        }
        if ( $type === 'phoneNumber' ){
            assertValidNumber( $answers['user'][$key] );
        }
    }

    function assertAnswered ( array $answers, $key ){
        if ( empty($answers['question'][$key]) ){
            throw new \Exception('Question has not been answered' );
        }
    }

    function assertValidNumber( string $phoneNumber ){
        //Change for UK numbers only
        if ( !preg_match('/^0[1-9][0-9]{9}$/', $phoneNumber) ){
            throw new \Exception( 'Invalid' );
        }
    }

    function assertValidEmail( string $emailAddress ){
        if ( !filter_var($emailAddress, FILTER_VALIDATE_EMAIL) ){
            throw new \Exception( 'Not valid' );
        }
    }

    function assertValidName( string $name ){
        if ( !preg_match("/^[a-z ,.\'-]+$/i", $name) ){
            throw new \Exception( 'Not valid' );
        }
    }

    function assertCheckAnswer ( array $answers, $key, array $choices ){
        //Check answer and perform different validation based on type
        if ( is_numeric($answers['question'][$key]) ){
            $answer = (int)($answers[$key]);
            if ( $answer !== $choices[0] ){
                throw new \Exception( 'Incorrect!' );
            }
        } else if ( is_array($answers['question'][$key]) ){
            if ( $answers[$key] !== $choices ){
                throw new \Exception( 'Incorrect!' );
            }
        } else if ( is_string($answers['question'][$key]) ) {
            if (strpos($answers[$key], $choices[0]) == false) {
                throw new \Exception('Incorrect!');
            }
        } else if ( $answers['question'][$key] === '' ){
            throw new \Exception( 'Good choice!' );
        } else {
            throw new \Exception( 'Unknown type' );
        }
    }

    function assertCheckCalculation ( array $answers, $key, $choices ){
        $range = (int)($answers['question'][$key]['range'] ?? 0);
        $number = (int)($answers['question'][$key]['number'] ?? 0);
        $result = $range + $number;
        if ( $result !== $choices[0] ){
            throw new \Exception( 'Incorrect!' );
        }
    }

    function redirect(bool $isSuccess){
        $url = 'index.php';
        if ( $isSuccess ){
            $url = 'success.php';
        }
        header( 'Location: http://localhost:8000/' . $url );
        exit();
    }


    //Making sure that POST is correct and is an array
    $answers = ( array ) ( $_POST ?? [] );

    //Declaring a score keeping variable
    $quizScore = 0;

    $rules = [
        'user' => [
            'fullName' => [
                'required' => true,
                'type' => 'string',
                'pattern' => "/^[a-z ,.\'-]+$/i",
            ],
            'emailAddress' => [
                'required' => true,
                'type' => 'email',
            ],
            'phoneNumber'  => [
                'required'    => true,
                'type' => 'phoneNumber',
                'phoneNumber' => 'uk',
            ],
        ],
        'question' => [
            '1' => [
                'correctChoices' => ['Stars'],
                'answerNeeded'  => false,
            ],
            '2' => [
                'correctChoices' => ['Tiger'],
                'answerNeeded'  => true,
            ],
            '3' => [
                'correctChoices' => ['Audi', 'Lamborghini'],
                'answerNeeded'   => true,
            ],
            '4' => [
                'correctChoices' => ['Rome'],
                'answerNeeded'   => true,
            ],
            '5' => [
                'correctChoices' => ['Arctic', 'Antarctic'],
                'answerNeeded'   => true,
            ],
            '6' => [
                'correctChoices' => ['Whitehouse'],
                'answerNeeded'   => true,
            ],
            '7' => [
                'correctChoices' => ['George Washington'],
                'answerNeeded'   => true,
            ],
            '8' => [
                'correctChoices' => [400],
                'answerNeeded'   => true,
            ],
            '9' => [
                'answerNeeded' => true
            ],
            '10' => [
                'correctChoices' => [150],
                'sliderInput'   => true,
            ],
            '11' => [
                'correctChoices' => [600],
                'sliderInput'   => true,
            ]
        ],
    ];

    $errors = [
        'user' => [],
        'question' => [],
    ];

    echo '<pre>';
    print_r($answers);
    echo '</pre>';

    foreach ( $rules['user'] as $key => $ruleSet ){
        $errors['user'][$key] = assertRequired($answers, $key);
        $errors['user'][$key] = assertType($answers, $key, $ruleSet['type']);
    }
    //Need to do foreach for question


    echo '<pre>';
    print_r($errors);
    echo '</pre>';

//    foreach ($rules as $rule => $ruleSet){
//        echo '<pre>';
//        print_r($rule);
//        echo '</pre>';
//        foreach ( $answers[$rule] as $value ){
//            echo '<pre>';
//            print_r($value);
//            echo '</pre>';
//        }
//    }

    $_SESSION['errors'] = $errors;
    $_SESSION['answers'] = $answers;

    redirect( empty(array_filter($errors['question'])) || empty(array_filter($errors['user'])) );

//    foreach ( $rules['user'] as $key => $ruleSet ){
//        $errors['user'][$key] = validate($answers['user'] ?? [], $key, $ruleSet);
//    }
//    foreach ( $rules['question'] as $key => $ruleSet ){
//        $errors['question'][$key] = validate( $answers['question'] ?? [], $key, $ruleSet );
//    }
//    function validate($answers, $key, array $ruleSet){
//        try {
//              if (  ){
//
//              }
//
//            if ( isset($ruleSet['required']) && $ruleSet['required'] ){
//                assertFilledOut( $answers, $key );
//            }
//            if ( isset($ruleSet['answerNeeded']) && $ruleSet['answerNeeded'] ){
//                assertAnswered( $answers, $key );
//            }
//            if ( isset($ruleSet['sliderInput']) && $ruleSet['sliderInput'] ){
//                assertCheckCalculation( $answers, $key, $ruleSet['correctChoices'] );
//            }
//            if ( isset($ruleSet['correctChoices']) && is_array($ruleSet['correctChoices']) ){
//                assertCheckAnswer($answers, $key, $ruleSet['correctChoices'] );
//            }
//        } catch ( \Exception $exception ) {
//            return $exception -> getMessage();
//        }
//    }
//Check if question is answered
//    function assertFilledOut( array $answers, $key){
//        //Get question from answers array and return true/false depending on whether set or not
//        if ( !isset($answers[$key]) ){
//            throw new \Exception('Required field has not been filled in' );
//        } else {
//            if ( strpos($key, 'Address') ){
//                if ( !filter_var($answers[$key], FILTER_VALIDATE_EMAIL) ){
//                    throw new \Exception( 'Not valid' );
//                }
//            } else if ( strpos($key, 'Name') ){
//                if ( !preg_match("/^[a-z ,.\'-]+$/i", $answers[$key]) ){
//                    throw new \Exception( 'Not valid' );
//                }
//            } else if ( strpos($key, 'Number') ){
//                if ( !phoneNumberValidation($answers[$key]) ){
//                    throw new \Exception( 'Not valid' );
//                }
//            }
//        }
//    }
//    foreach ( $rules as $key => $rule ) {
//        $errors[$key] = validate($answers, $key, $rule);
//        echo "<pre>";
//        print_r($key);
//        echo "</pre>";
//    }
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