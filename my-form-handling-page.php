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

        //Validation on the user's full name
        if ( isset($_POST['user_name']) ){
            $fullName = $_POST['user_name'];
            if ( !preg_match("/^[a-z ,.\'-]+$/i", $fullName)){
                echo "<div> Invalid name given </div>";
            } else {
                echo "<div> <b>Name:</b> $fullName </div>";
            }
        } else {
            echo "<div> No name has been entered </div>";
        };

        //Validation on the user's email
        if ( isset($_POST['user_email'])){
            $emailAddress = $_POST['user_email'];
            if ( !filter_var($emailAddress, FILTER_VALIDATE_EMAIL) ){
                echo "<div> Email address not valid </div>";
            } else {
                echo "<div> <b>Email address:</b> $emailAddress </div>";
            }
        } else {
            echo "<div> No email has been entered </div>";
        };

        //Validation on the user's phone number
        if ( isset($_POST['phoneNumber']) ){
            $mobileNumber = $_POST['phoneNumber'];
            $justNumbers = preg_replace("/[^0-9]/", '', $mobileNumber);
            if ( strlen($justNumbers) == 11 ){
                $justNumbers = preg_replace("/^[01]/", '', $justNumbers);
            }
            if ( strlen($justNumbers) == 10 ){
                echo "<div><b>Phone number:</b> $mobileNumber <hr></div>";
            }
        } else {
            echo "<div> No phone number has been entered <hr></div>";
        };

        //Validation on Q1 - which will always have a value so isset is not needed in this case
        $question1 = $_POST['question1'];
        if ($question1 === 'Stars'){
            echo "<div> <b>Question 1 Answer:</b> <br/> $question1 </div>";
            echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
            $quizScore += 1;
        } else {
            echo "<div> <b>Question 1 Answer:</b> <br/> $question1 </div>";
            echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
            $quizScore -= 1;
        };

        //Validation on Q2 - can be empty so isset is needed
        if ( isset($_POST['animal']) ){
            $question2 = $_POST['animal'];
            if ($question2 === 'Tiger'){
                echo "<div> <b>Question 2 Answer:</b> <br/> $question2 </div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 2 Answer:</b> <br/> $question2 </div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 2 Answer:</b> <br/> Not answered <hr></div>";
        }

        //Validation on Q3 - multi choice dropdown
        if ( isset($_POST['question3']) ){
            $question3 = $_POST['question3'];
            $answers = ['Audi', 'Lamborghini'];
            $question3Answers = array_intersect($question3, $answers);
            if ($question3Answers === $answers){
                echo "<div> <b>Question 3 Answers:</b> <br/>" . join('<br/>', $question3) . "</div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 3 Answers:</b> <br/>" . join('<br/>', $question3) . "</div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 3 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q4 - multi choice check box, one answer
        if ( isset($_POST['city']) ){
            $question4 = $_POST['city'];
            $answers = ['Rome'];
            $question4Answers = array_intersect($question4, $answers);
            if ($question4Answers === $answer){
                echo "<div> <b>Question 4 Answers:</b> <br/>" . join('<br/>', $question4) . "</div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 4 Answers:</b> <br/>" . join('<br/>', $question4) . "</div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 4 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q5 - multi choice check box, two answers
        if ( isset($_POST['pole']) ){
            $question5 = $_POST['pole'];
            $answers = ['Arctic', 'Antarctic'];
            $question5Answers = array_intersect($question5, $answers);
            if ($question5Answers === $answers){
                echo "<div> <b>Question 5 Answers:</b> <br/>" . join('<br/>', $question5) . "</div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 5 Answers:</b> <br/>" . join('<br/>', $question5) . "</div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 5 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q6 - must contain specific string
        if ( isset($_POST['question6']) ){
            $question6 = $_POST['question6'];
            if (strpos($question6, 'Whitehouse') !== false){
                echo "<div> <b>Question 6 Answer:</b> <br/> $question6 </div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 6 Answer:</b> <br/> $question6 </div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 6 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q7 - must be specific string
        if ( isset($_POST['question7']) ){
            $question7 = $_POST['question7'];
            if ($question7 === "George Washington"){
                echo "<div> <b>Question 7 Answer:</b> <br/> $question7 </div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 7 Answer:</b> <br/> $question7 </div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 7 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q8 - must be more than a certain number
        if ( isset($_POST['question8']) ){
            $question8 = $_POST['question8'];
            if($question8 > 400){
                echo "<div> <b>Question 8 Answer:</b> <br/> $question8 </div>";
                echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
                $quizScore += 1;
            } else {
                echo "<div> <b>Question 8 Answer:</b> <br/> $question8 </div>";
                echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
                $quizScore -= 1;
            }
        } else {
            echo "<div> <b>Question 8 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q9 - just needs to check whether empty or not
        if ( isset($_POST['question9']) ){
            $question9 = $_POST['question9'];
            echo "<div> <b>Question 9 Answer:</b> <br/> $question9 <hr></div>";
        } else {
            echo "<div> <b>Question 9 Answer:</b> <br/> Not answered <hr></div>";
        };

        //Validation on Q10 - needs to be exact number
        //These will always be set and have default values
        $question10Slider = $_POST['sliderOne'];
        $question10NumberInput = $_POST['numberInputOne'];
        $question10Result = $_POST['sliderOne'] + $_POST['numberInputOne'];
        if ($question10Result === 150){
            echo "<div> <b>Question 10 Answer:</b> <br/> $question10Result </div>";
            echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
            $quizScore += 1;
        } else {
            echo "<div> <b>Question 10 Answer:</b> <br/> $question10Result </div>";
            echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
            $quizScore -= 1;
        };

        //Validation on Q11 - needs to be exact number
        //These will always be set and have default values
        $question11Slider = $_POST['sliderTwo'];
        $question11NumberInput = $_POST['numberInputTwo'];
        $question11Result = $_POST['sliderTwo'] + $_POST['numberInputTwo'];
        if ($question11Result === 600){
            echo "<div> <b>Question 11 Answer:</b> <br/> $question11Result </div>";
            echo "<div> <b>Result:</b> <br/> Correct <hr></div>";
            $quizScore += 1;
        } else {
            echo "<div> <b>Question 11 Answer:</b> <br/> $question11Result </div>";
            echo "<div> <b>Result:</b> <br/> Incorrect <hr></div>";
            $quizScore -= 1;
        };
        echo "<pre>";
        print_r($_POST);
        print_r($_SERVER);
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




