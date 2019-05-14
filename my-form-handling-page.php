<?php

    session_start();

    function assert_required( array $answers, $key ){
        if ( empty($answers[$key]) ){
            throw new \Exception( 'Required field has not been filled in' );
        }
    }

    function assert_phoneNumber( $answers, $key ){
        //Change for UK numbers only
        if ( !preg_match('/^0[1-9][0-9]{9}$/', $answers[$key]) ){
            throw new \Exception( 'Invalid' );
        }
    }

    function assert_emailAddress( $answers, $key ){
        if ( !filter_var($answers[$key], FILTER_VALIDATE_EMAIL) ){
            throw new \Exception( 'Not valid' );
        }
    }

    function assert_pattern( $answers, $key ){
        if ( !preg_match("/^[a-z ,.\'-]+$/i", $answers[$key]) ){
            throw new \Exception( 'Not valid' );
        }
    }

    function assert_correctChoices ( $answers, $key, $rule ){
        if ( is_numeric($answers[$key]) ){
            $answer = (int)($answers[$key]);
            if ( $answer !== $rule[0] ){
                throw new \Exception( 'Incorrect!' );
            }
        } else if ( is_array($answers[$key]) ){
            if ( $answers[$key] !== $rule ){
                throw new \Exception( 'Incorrect!' );
            }
        } else if ( is_string($answers[$key]) ) {
            if ( strpos($answers[$key], $rule[0] ) == false && $answers[$key] !== $rule[0] ) {
                throw new \Exception('Incorrect!');
            }
        } else if ( $answers[$key] === '' ){
            throw new \Exception( 'Good choice!' );
        } else {
            throw new \Exception( 'Unknown type' );
        }
    }

    function assert_CheckCalculation ( array $answers, $key, $rule ){
        $range = (int)($answers[$key]['range'] ?? 0);
        $number = (int)($answers[$key]['number'] ?? 0);
        $result = $range + $number;
        if ( $result !== $rule[0] ){
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
                'pattern' => "/^[a-z ,.\'-]+$/i",
            ],
            'emailAddress' => [
                'required' => true,
            ],
            'phoneNumber'  => [
                'required'    => true,
                'phoneNumber' => 'uk',
            ],
        ],
        'question' => [
            '1' => [
                'required' => true,
                'correctChoices' => ['Stars'],
            ],
            '2' => [
                'required' => true,
                'correctChoices' => ['Tiger'],
            ],
            '3' => [
                'required' => true,
                'correctChoices' => ['Audi', 'Lamborghini'],
            ],
            '4' => [
                'required' => true,
                'correctChoices' => ['Rome'],
            ],
            '5' => [
                'required' => true,
                'correctChoices' => ['Arctic', 'Antarctic'],
            ],
            '6' => [
                'required' => true,
                'correctChoices' => ['Whitehouse'],
            ],
            '7' => [
                'required' => true,
                'correctChoices' => ['George Washington'],
            ],
            '8' => [
                'required' => true,
                'correctChoices' => [400],
            ],
            '9' => [
                'required' => true,
            ],
            '10' => [
                'required' => true,
                'checkCalculation' => [150],
            ],
            '11' => [
                'required' => true,
                'checkCalculation' => [600],
            ]
        ],
    ];

    $errors = [
        'user' => [],
        'question' => [],
    ];

    foreach ( $rules as $groupName => $groupRules ){
        // loop through all "groups" properties/rule sets
        foreach ( $groupRules as $property => $ruleSet ){
            try {
                foreach ( $ruleSet as $ruleName => $rule ){
                    $functionName = 'assert_' . $ruleName;

                    if ( !function_exists($functionName) ){
                       throw new \Exception ( 'Function ' . $functionName . ' does not exist' );
                    }

                    $functionName ( $answers[$groupName] ?? [], $property, $rule );
                }
            } catch ( \Exception $exception ){
                $errors[$groupName] = $errors[$groupName] ?? [];
                $errors[$groupName][$property] = $exception -> getMessage();
            }
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['answers'] = $answers;

    redirect( empty(array_filter($errors['question'])) && empty(array_filter($errors['user'])) );

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