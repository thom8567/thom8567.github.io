<?php

    header("Content-type:application/json");

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

    function assert_MultipleAnswers ( $answer, $key, $rule ){
        if ( !$rule ){
            if ( count( $answer[$key] ) > 1 ){
                throw new \Exception( 'Too many answers' );
            }
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
                'multipleAnswers' => false,
                'correctChoices' => ['Rome'],
            ],
            '5' => [
                'required' => true,
                'multipleAnswers' => true,
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

    $response = [
        'success'  => empty( array_filter($errors['question']) ) && empty( array_filter($errors['user']) ),
        'errors'   => $errors,
    ];

    echo json_encode($response);

?>