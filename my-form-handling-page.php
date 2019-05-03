<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Answers</title>
</head>
<body>

    <?php

        echo "<p>Welcome to PHP</p>";

        //Declaring a score keeping variable
        $quizScore = 0;

        //Making sure that POST is correct and is an array
        $answers = ( array ) ( $_POST ?? [] );

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

        function validate($answers, $key, array $ruleSet){
            try {
                if( isset($ruleSet['required']) && $ruleSet['required'] ){
                    assertFilledOut( $answers, $key, $ruleSet );
                }
                if( isset($ruleSet['answerNeeded']) && $ruleSet['answerNeeded'] ){
                    assertAnswered( $answers, $key );
                }
                if( isset($ruleSet['sliderInput']) && $ruleSet['sliderInput'] ){
                    assertCheckCalculation( $answers, $key, $ruleSet['correctChoices'] );
                }
                if( isset($ruleSet['correctChoices']) && is_array($ruleSet['correctChoices']) ){
                    assertCheckAnswer($answers, $key, $ruleSet['correctChoices'] );
                }
            } catch ( \Exception $exception ) {
                return $exception -> getMessage();
            }
        }

        //Check if question is answered
        function assertFilledOut( array $answers, $key, $ruleSet ){
            //Get question from answers array and return true/false depending on whether set or not
            if ( !isset($answers[$key]) ){
                throw new \Exception('Required field has not been filled in' );
            } else {
                if ( strpos($key, 'email') ){
                    if ( filter_var($answers[$key], FILTER_VALIDATE_EMAIL) ){
                        throw new \Exception( 'Email is valid' );
                    } else {
                        throw new \Exception( 'Email is not valid' );
                    }
                } else if ( strpos($key, 'Name') ){
                    if ( preg_match("/^[a-z ,.\'-]+$/i", $answers[$key]) ){
                        throw new \Exception( 'Name is valid' );
                    } else {
                        throw new \Exception( 'Name is not valid' );
                    }
                } else if ( strpos($key, 'phone') ){
                    if ( phoneNumberValidation($answers[$key]) ){
                        throw new \Exception( 'Valid number' );
                    } else {
                        throw new \Exception( 'Invalid number' );
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
                if ( $answer === $choices[0] ){
                    throw new \Exception( 'Correct!' );
                } else {
                    throw new \Exception( 'Incorrect!' );
                }
            } else if ( is_array($answers[$key]) ){
                if ( $answers[$key] === $choices ){
                    throw new \Exception( 'Correct!' );
                } else {
                    throw new \Exception( 'Incorrect!' );
                }
            } else if ( is_string($answers[$key]) ){
                if ( strpos( $answers[$key], $choices[0] ) !== false ){
                    throw new \Exception( 'Correct!' );
                } else {
                    throw new \Exception( 'Incorrect!' );
                }
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
                if ( $result === $choices[0] ){
                    throw new \Exception( 'Correct!' );
                } else {
                    throw new \Exception( 'Incorrect!' );
                }
            }
        }

        function phoneNumberValidation($phoneNumber){
            //Ensure that the number is just a number with no extra characters
            $justNumbers = preg_replace('/[^0-9]/', '', $phoneNumber);

            //Check if it has a leading number and eliminate it
            if ( strlen($justNumbers) == 11 ){
                $justNumbers = preg_replace("/^1/", '',$justNumbers);
            }

            //If there are 10 digits left the most likely, it is valid
            if ( strlen($justNumbers) == 10 ){
                return true;
            } else {
                return false;
            }
        }

        foreach ( $rules as $key => $rule ) {
            $errors[$key] = validate($answers, $key, $rule);
        }

        $questionKeys = array_keys($errors);

        foreach ( $questionKeys as $questionNumber ){
            $response = $errors[$questionNumber];
            $questionNumber = preg_replace('/(?<!\ )[A-Z]/', ' $0', $questionNumber);
            //CURRENTLY NOT VALIDATING AGAINST DOUBLE DIGITS CORRECTLY
            $questionNumber = preg_replace('/(?<!\ )[0-9]/', ' $0', $questionNumber);
            $questionNumber = preg_replace('/(?<!\ )[0-9][0-9]/', ' $0', $questionNumber);
            $questionNumber = ucwords($questionNumber);
            echo "<div> <b>$questionNumber</b> <br/> $response <hr/> </div>";
        }

        echo "<pre>";
        print_r($answers);
        print_r($errors);
        echo "</pre>";
    ?>

    <div>
        <button id="goBackButton">Go Back</button> <br/>
    </div>

    <script>
        function goBack(){
          window.history.back();
        }
        document.getElementById("goBackButton").addEventListener("click", goBack);

    </script>

</body>
</html>




