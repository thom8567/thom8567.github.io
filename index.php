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

        function errorAlert($errors){
            if ( !empty($errors) ){
                echo "<p><b>Questions have errors</b></p>";
            }
        }

        function printError(string $question, string $section, $errors){
            if ( !empty($errors[$section][$question]) ){
                echo "<p><b>".formatQuestionNumbers($question)."</b> - ".$errors[$section][$question]."</p>";
            }
        }

        if ( !empty($_SESSION) ){
            $errors = $_SESSION['errors'];
        } else {
            $errors = [];
        }

        echo "<pre>";
        print_r($errors);
        echo "</pre>";

    ?>

    <header>
        <?php
            errorAlert($errors);
        ?>
    </header>

    <form action="/my-form-handling-page.php" method="post">
        <h1>Welcome to my Quiz!</h1>
        <h2>Please fill out your information below:</h2>
        <div>
            <label for="name">Full Name:</label> <br/>
            <input type="text" id="name" name="user[fullName]" maxlength="40" autocomplete="name" required>
            <?php
                printError( 'fullName', 'user', $errors );
            ?>
        </div>
        <div>
            <label for="mail">E-mail:</label> <br/>
            <input type="email" id="mail" name="user[emailAddress]" maxlength="100" autocomplete="email" required>
            <?php
                printError( 'emailAddress', 'user', $errors );
            ?>
        </div>
        <div>
            <label for="phoneNumber">Mobile Phone Number (UK Numbers Only - e.g. 01234567891):</label> <br/>
            <input type="number" id="phoneNumber" name="user[phoneNumber]" maxlength="11" placeholder="01234567891" required>
            <?php
                printError( 'phoneNumber', 'user', $errors );
            ?>
        </div>
        <h2>Quiz:</h2>
        <div>
            <label for="question1">1. What are the bright lights that appear at night in the sky called?</label> <br/>
            <select id="question1" name="question[1]">
                <option value="Stars">Stars</option>
                <option value="Streetlight">Streetlights</option>
                <option value="Aeroplane">Aeroplane</option>
                <option value="Satellites">Satellites</option>
            </select>
            <?php
                printError( '1', 'question', $errors );
            ?>
        </div>
        <div>
            <img src="assets/tiger.jpg"
                 alt="An apex predator that lives in the Jungle. It is orange and has a stripey pattern to help it blend in."> <br/>
            <label>2. What is the name of this animal?</label> <br/>
            <input type="radio" name="question[2]" value="Lion">Lion <br/>
            <input type="radio" name="question[2]" value="Tiger">Tiger <br/>
            <input type="radio" name="question[2]" value="Elephant">Elephant <br/>
            <input type="radio" name="question[2]" value="Duck">Duck <br/>
            <?php
                printError( '2', 'question', $errors );
            ?>
        </div>
        <div>
            <!-- needs code to allow multiple to be selected without holding down ctrl -->
            <label for="question3">3. Which car brands does Volkswagen own, apart from Volkswagen?</label> <br/>
            <select id="question3" name="question[3][]" size="two" multiple>
                <option value="Volvo">Volvo</option>
                <option value="Saab">Saab</option>
                <option value="Audi">Audi</option>
                <option value="Lamborghini">Lamborghini</option>
                <option value="BMW">BMW</option>
            </select>
            <?php
                printError( '3', 'question', $errors );
            ?>
        </div>
        <div>
            <!-- this needs code to force it to only be able to use one checkbox, this will be done below -->
            <label>4. Which European capital is known as ‘The City of the Seven Hills’?</label> <br/>
            <input type="checkbox" name="question[4][]" value="Berlin">Berlin <br/>
            <input type="checkbox" name="question[4][]" value="Rome">Rome <br/>
            <input type="checkbox" name="question[4][]" value="London">London <br/>
            <input type="checkbox" name="question[4][]" value="Paris">Paris <br/>
            <input type="checkbox" name="question[4][]" value="Madrid">Madrid <br/>
            <?php
                printError( '4', 'question', $errors );
            ?>
        </div>
        <div>
            <label>5. What are the places called on each pole of the Earth?</label> <br/>
            <input type="checkbox" name="question[5][]" value="Arctic">Arctic <br/>
            <input type="checkbox" name="question[5][]" value="North America">North America <br/>
            <input type="checkbox" name="question[5][]" value="Antarctic">Antarctic <br/>
            <input type="checkbox" name="question[5][]" value="South America">South America <br/>
            <input type="checkbox" name="question[5][]" value="Asia">Asia <br/>
            <?php
                printError( '5', 'question', $errors );
            ?>
        </div>
        <div>
            <label for="question6">6. What is the name of the presidential house in the USA?</label> <br/>
            <input type="text" id="question6" name="question[6]"> <br/>
            <?php
                printError( '6', 'question', $errors );
            ?>
        </div>
        <div>
            <label for="question7">7. Who was the first president of the USA?</label> <br/>
            <input type="text" id="question7" name="question[7]"> <br/>
            <?php
                printError( '7', 'question', $errors );
            ?>
        </div>
        <div>
            <label for="question8">8. What is (10 + 10) ^ 2 ?</label> <br/>
            <input type="number" step="1" id="question8" name="question[8]"> <br/>
            <?php
                printError( '8', 'question', $errors );
            ?>
        </div>
        <div>
            <label for="question9">9. What is your favourite browser?</label> <br/>
            <input list="browsers" id="question9" name="question[9]">
            <datalist id="browsers">
                <option value="Internet Explorer">
                <option value="Microsoft Edge">
                <option value="Google Chrome">
                <option value="Mozilla Firefox">
            </datalist>
            <?php
                printError( '9', 'question', $errors );
            ?>
        </div>
        <div>
            <label>10. What is 100 + 50?</label> <br/>
            <input type="range" min="0" max="500" name="question[10][range]" value="0" /> +
            <input type="number" name="question[10][number]" value="0" /> =
            <output id="result" name="result">0</output>
            <?php
                printError( '10', 'question', $errors );
            ?>
        </div>
        <div>
            <label>11. What is 500 + 100?</label> <br/>
            <input type="range" min="0" max="1000" name="question[11][range]" value="0" /> +
            <input type="number" name="question[11][number]" value="0" min="0" /> =
            <output id="resultTwo" name="resultTwo">0</output>
            <?php
                printError( '11', 'question', $errors );
            ?>
        </div>

        <input type="submit" value="Submit"/><br/>
        <input type="reset" value="Reset" />
    </form>
    <button id="alertButton">Show Alert!</button><br/>

    <script>

        function showAlert(){
          alert("THIS IS AN ALERT!");
        }

        function createHandler( rangeSelector, inputSelector, outputSelector ){
          var range = document.querySelector( rangeSelector );
          var input = document.querySelector( inputSelector );
          var output = document.querySelector( outputSelector );

          function handleUpdate(){
            if ( isNaN(parseInt(input.value)) ){
              input.value = 0;
            }
            output.value = parseInt( range.value ) + parseInt( input.value );
          }
          range.oninput = handleUpdate;
          input.oninput = handleUpdate;
        }

        document.getElementById( "alertButton" ).addEventListener( "click", showAlert );
        createHandler( 'input[name="question[10][range]"]', 'input[name="question[10][number]"]', 'output[name="result"]' );
        createHandler( 'input[name="question[11][range]"]', 'input[name="question[11][number]"]', 'output[name="resultTwo"]' );

    </script>

</body>

</html>