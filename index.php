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

    <?php
        require __DIR__ . '/includes/cdn-links.php';
    ?>

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
                echo '<div class="alert alert-danger text-center" role="alert"> 
                      <p><b>Questions have errors</b></p>
                      </div>';
            }
        }

        function printError(string $question, string $section, $errors){
            if ( !empty($errors[$section][$question]) ){
                echo "<p><b>".formatQuestionNumbers($question)."</b> - ".$errors[$section][$question]."</p>";
            }
        }

        if ( !empty($_SESSION['errors']) && !empty($_SESSION['answers']) ){
            $errors = $_SESSION['errors'];
            $answers = $_SESSION['answers'];
            unset($_SESSION['errors']);
            unset($_SESSION['answers']);
        } else {
            $errors = [];
            $answers = [];
        }

    ?>

    <div class="container form-colour">
        <h1 class="text-center">Welcome to my Quiz!</h1>
        <form action="/my-form-handling-page.php" method="post" class="container">

            <?php
                errorAlert($errors);
            ?>

            <h3>Please fill out your information below:</h3>
            <div class="form-group">
                <label for="name">Full Name:</label> <br/>
                <input type="text" class="form-control" id="name" name="user[fullName]" maxlength="40" autocomplete="name"
                       required value="<?=$answers['user']['fullName'] ?? ''; ?>">
                <?php
                    printError( 'fullName', 'user', $errors );
                ?>
            </div>
            <div class="form-group">
                <label for="mail">E-mail:</label> <br/>
                <input type="email" class="form-control" id="mail" name="user[emailAddress]" maxlength="100" autocomplete="email" required
                       value="<?=$answers['user']['emailAddress'] ?? ''; ?>">
                <?php
                    printError( 'emailAddress', 'user', $errors );
                ?>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Mobile Phone Number (UK Numbers Only - e.g. 01234567891):</label> <br/>
                <input type="number" class="form-control" id="phoneNumber" name="user[phoneNumber]" maxlength="11" placeholder="01234567891" required
                       value="<?=$answers['user']['phoneNumber'] ?? ''; ?>">
                <?php
                    printError( 'phoneNumber', 'user', $errors );
                ?>
            </div>
            <h3>Quiz:</h3>
            <div class="form-group">
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
            <div class="form-group">
                <img src="assets/tiger.jpg"
                     alt="An apex predator that lives in the Jungle. It is orange and has a stripey pattern to help it blend in."> <br/>
                <label>2. What is the name of this animal?</label> <br/>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question[2]" value="Lion" id="animal1">
                    <label class="form-check-label" for="animal1">Lion</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question[2]" value="Tiger" id="animal2">
                    <label class="form-check-label" for="animal2">Tiger</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question[2]" value="Elephant" id="animal3">
                    <label class="form-check-label" for="animal3">Elephant</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="question[2]" value="Duck" id="animal4">
                    <label class="form-check-label" for="animal4">Duck</label><br/>
                    <?php
                        printError( '2', 'question', $errors );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="question3">3. Which car brands does Volkswagen own, apart from Volkswagen?</label> <br/>
                <select id="question3" name="question[3][]" multiple class="form-control">
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
            <div class="form-group">
                <label>4. Which European capital is known as ‘The City of the Seven Hills’?</label> <br/>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[4][]" value="Berlin" id="country1">
                    <label class="form-check-label" for="country1">Berlin</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[4][]" value="Rome" id="country2">
                    <label class="form-check-label" for="country2">Rome</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[4][]" value="London" id="country3">
                    <label class="form-check-label" for="country3">London</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[4][]" value="Paris" id="country4">
                    <label class="form-check-label" for="country4">Paris</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[4][]" value="Madrid" id="country5">
                    <label class="form-check-label" for="country5">Madrid</label><br/>
                    <?php
                        printError( '4', 'question', $errors );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label>5. What are the places called on each pole of the Earth?</label> <br/>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[5][]" value="Arctic" id="pole1">
                    <label class="form-check-label" for="pole1">Arctic</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[5][]" value="North America" id="pole2">
                    <label class="form-check-label" for="pole2">North America</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[5][]" value="Antarctic" id="pole3">
                    <label class="form-check-label" for="pole3">Antarctic</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[5][]" value="South America" id="pole4">
                    <label class="form-check-label" for="pole4">South America</label><br/>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="question[5][]" value="Asia" id="pole5">
                    <label class="form-check-label" for="pole5">Asia</label><br/>
                    <?php
                        printError( '5', 'question', $errors );
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="question6">6. What is the name of the presidential house in the USA?</label> <br/>
                <input type="text" class="form-control" id="question6" name="question[6]" value="<?=$answers['question']['6'] ?? ''; ?>"> <br/>
                <?php
                    printError( '6', 'question', $errors );
                ?>
            </div>
            <div class="form-group">
                <label for="question7">7. Who was the first president of the USA?</label> <br/>
                <input type="text" class="form-control" id="question7" name="question[7]" value="<?=$answers['question']['7'] ?? ''; ?>"> <br/>
                <?php
                    printError( '7', 'question', $errors );
                ?>
            </div>
            <div class="form-group">
                <label for="question8">8. What is (10 + 10) ^ 2 ?</label> <br/>
                <input type="number" class="form-control" step="1" id="question8" name="question[8]" value="<?=$answers['question']['8'] ?? ''; ?>"> <br/>
                <?php
                    printError( '8', 'question', $errors );
                ?>
            </div>
            <div class="form-group">
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
            <div class="form-group">
                <label>10. What is 100 + 50?</label> <br/>
                <input type="range" min="0" max="500" name="question[10][range]" value="0" /> +
                <input type="number" name="question[10][number]" min="0" /> =
                <output id="result" name="result">0</output>
                <?php
                    printError( '10', 'question', $errors );
                ?>
            </div>
            <div class="form-group">
                <label>11. What is 500 + 100?</label> <br/>
                <input type="range" min="0" max="1000" name="question[11][range]" value="0" /> +
                <input type="number" name="question[11][number]" min="0" /> =
                <output id="resultTwo" name="resultTwo">0</output>
                <?php
                    printError( '11', 'question', $errors );
                ?>
            </div>

            <div class="row">
                <div class="col-sm text-left">
                    <button class="btn btn-success btn-outline-dark" type="submit">Submit</button>
                </div>

                <div class="col-sm text-center">
                    <button class="btn btn-warning btn-outline-dark" id="alertButton" type="button">Show Alert!</button>
                </div>

                <div class="col-sm text-right">
                    <button class="btn btn-danger btn-outline-dark" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>

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

        //Allowing dropdown select boxes to be able to just click to be able to select and unselect multiple options
        $('option').mousedown( function( e ) {
          e.preventDefault();
          $(this).prop( 'selected', !$(this).prop('selected') );
          return false;
        });

    </script>

</body>

</html>