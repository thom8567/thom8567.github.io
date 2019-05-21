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

    <div class="text-center" id="error-alert"></div>

    <div class="container form-colour">
        <h1 class="text-center">Welcome to my Quiz!</h1>
        <form action="/my-form-handling-page.php" method="post" class="container" id="quiz-form">
            <h3>Please fill out your information below:</h3>
            <div class="form-group can-valid">
                <label for="name">Full Name:</label>
                <input type="text" class="form-control can-valid" id="name" name="user[fullName]" maxlength="40" autocomplete="name"
                       required>
                <div id="success_user_fullName" class="success-wrapper"></div>
                <div id="errors_user_fullName" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="mail">E-mail:</label>
                <input type="email" class="form-control can-valid" id="mail" name="user[emailAddress]" maxlength="100" autocomplete="email"
                       required>
                <div id="success_user_emailAddress" class="success-wrapper"></div>
                <div id="errors_user_emailAddress" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="phoneNumber">Mobile Phone Number (UK Numbers Only):</label>
                <input type="number" class="form-control can-valid" id="phoneNumber" name="user[phoneNumber]" maxlength="11" placeholder="e.g. 01234567891"
                       required>
                <div id="success_user_phoneNumber" class="success-wrapper"></div>
                <div id="errors_user_phoneNumber" class="errors-wrapper"></div>
            </div>
            <h3>Quiz:</h3>
            <div class="form-group can-valid">
                <label for="question1">1. What are the bright lights that appear at night in the sky called?</label>
                <select id="question1" name="question[1]" class="form-control can-valid">
                    <option value="Stars">Stars</option>
                    <option value="Streetlight">Streetlights</option>
                    <option value="Aeroplane">Aeroplane</option>
                    <option value="Satellites">Satellites</option>
                </select>
                <div id="success_question_1" class="success-wrapper"></div>
                <div id="errors_question_1" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label>2. What is the name of this animal?</label>
                <div class="text-center">
                    <img src="assets/tiger.jpg"
                         alt="An apex predator that lives in the Jungle. It is orange and has a stripey pattern to help it blend in."
                         class="rounded">
                </div>
                <div class="row align-items-center">
                    <div class="form-check form-check-inline col-md can-valid">
                        <input class="form-check-input can-valid" type="radio" name="question[2]" value="Lion" id="animal1">
                        <label class="form-check-label" for="animal1">Lion</label>
                    </div>
                    <div class="form-check form-check-inline col-md can-valid">
                        <input class="form-check-input can-valid" type="radio" name="question[2]" value="Tiger" id="animal2">
                        <label class="form-check-label" for="animal2">Tiger</label>
                    </div>
                    <div class="form-check form-check-inline col-md can-valid">
                        <input class="form-check-input can-valid" type="radio" name="question[2]" value="Elephant" id="animal3">
                        <label class="form-check-label" for="animal3">Elephant</label>
                    </div>
                    <div class="form-check form-check-inline col-md can-valid">
                        <input class="form-check-input can-valid" type="radio" name="question[2]" value="Duck" id="animal4">
                        <label class="form-check-label" for="animal4">Duck</label>
                    </div>
                </div>
                <div id="success_question_2" class="success-wrapper"></div>
                <div id="errors_question_2" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="question3">3. Which car brands does Volkswagen own, apart from Volkswagen?</label>
                <select id="question3" name="question[3][]" multiple class="form-control can-valid">
                    <option value="Volvo">Volvo</option>
                    <option value="Saab">Saab</option>
                    <option value="Audi">Audi</option>
                    <option value="Lamborghini">Lamborghini</option>
                    <option value="BMW">BMW</option>
                </select>
                <div id="success_question_3" class="success-wrapper"></div>
                <div id="errors_question_3" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label>4. Which European capital is known as ‘The City of the Seven Hills’?</label>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[4][]" value="Berlin" id="country1">
                    <label class="form-check-label" for="country1">Berlin</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[4][]" value="Rome" id="country2">
                    <label class="form-check-label" for="country2">Rome</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[4][]" value="London" id="country3">
                    <label class="form-check-label" for="country3">London</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[4][]" value="Paris" id="country4">
                    <label class="form-check-label" for="country4">Paris</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[4][]" value="Madrid" id="country5">
                    <label class="form-check-label" for="country5">Madrid</label>
                </div>
                <div id="success_question_4" class="success-wrapper"></div>
                <div id="errors_question_4" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label>5. What are the places called on each pole of the Earth?</label>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[5][]" value="Arctic" id="pole1" >
                    <label class="form-check-label" for="pole1">Arctic</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[5][]" value="North America" id="pole2">
                    <label class="form-check-label" for="pole2">North America</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[5][]" value="Antarctic" id="pole3">
                    <label class="form-check-label" for="pole3">Antarctic</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[5][]" value="South America" id="pole4">
                    <label class="form-check-label" for="pole4">South America</label>
                </div>
                <div class="form-check can-valid">
                    <input class="form-check-input can-valid" type="checkbox" name="question[5][]" value="Asia" id="pole5">
                    <label class="form-check-label" for="pole5">Asia</label>
                </div>
                <div id="success_question_5" class="success-wrapper"></div>
                <div id="errors_question_5" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="question6">6. What is the name of the presidential house in the USA?</label>
                <input type="text" class="form-control can-valid" id="question6" name="question[6]"
                       autocomplete="off">
                <div id="success_question_6" class="success-wrapper"></div>
                <div id="errors_question_6" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="question7">7. Who was the first president of the USA?</label>
                <input type="text" class="form-control can-valid" id="question7" name="question[7]"
                       autocomplete="off">
                <div id="success_question_7" class="success-wrapper"></div>
                <div id="errors_question_7" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="question8">8. What is (10 + 10) ^ 2 ?</label>
                <input type="number" class="form-control can-valid" step="1" id="question8" name="question[8]"
                       autocomplete="off">
                <div id="success_question_8" class="success-wrapper"></div>
                <div id="errors_question_8" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label for="question9">9. What is your favourite browser?</label>
                <input class="form-control can-valid" list="browsers" id="question9" name="question[9]">
                <datalist id="browsers">
                    <option value="Internet Explorer">
                    <option value="Microsoft Edge">
                    <option value="Google Chrome">
                    <option value="Mozilla Firefox">
                </datalist>
                <div id="success_question_9" class="success-wrapper"></div>
                <div id="errors_question_9" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label>10. What is 100 + 50?</label>
                <input class="can-valid" type="range" min="0" max="500" name="question[10][range]" value="0" /> +
                <input class="can-valid" type="number" name="question[10][number]" min="0" /> =
                <output id="result" name="result">0</output>
                <div id="success_question_10" class="success-wrapper"></div>
                <div id="errors_question_10" class="errors-wrapper"></div>
            </div>
            <div class="form-group can-valid">
                <label>11. What is 500 + 100?</label>
                <input class="can-valid" type="range" min="0" max="1000" name="question[11][range]" value="0" /> +
                <input class="can-valid" type="number" name="question[11][number]" min="0" /> =
                <output id="resultTwo" name="resultTwo">0</output>
                <div id="success_question_11" class="success-wrapper"></div>
                <div id="errors_question_11" class="errors-wrapper"></div>
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

    <script id="error-template" type="text/x-handlebars-template">
        <div class="invalid-feedback">
            {{error}}
        </div>
    </script>

    <script id="success-template" type="text/x-handlebars-template">
        <div class="valid-feedback">
            Correct!
        </div>
    </script>

    <script id="banner-template" type="text/x-handlebars-template">
        <div class="alert alert-danger" role="alert">
            <h2>Some answers are incorrect!</h2>
        </div>
    </script>

    <script>

        const errorSource = document.getElementById( 'error-template' ).innerHTML;
        var errorsTemplate = Handlebars.compile(errorSource);
        const successSource = document.getElementById( 'success-template' ).innerHTML;
        var successTemplate = Handlebars.compile(successSource);
        const bannerSource = document.getElementById( 'banner-template' ).innerHTML;
        var bannerTemplate = Handlebars.compile(bannerSource);

        $( function(){
          $( '#quiz-form' ).on( 'submit', function( e ){
            e.preventDefault();
            let data = $( "#quiz-form :input" ).serialize();

            //Remove all errors and class
            $('.can-valid').removeClass( 'is-invalid is-valid' );
            $('.errors-wrapper, .success-wrapper').html('');
            $( '#error-alert' ).html( '' );
            let error = '';

            $.post( '/my-form-handling-page.php', data, function ( returnedData ){
                let errors = returnedData['errors'];
                if ( !returnedData['success'] ) {
                  Object.keys(errors).forEach(function (section) {
                    Object.keys(errors[section]).forEach(function (questionNumber) {
                      error = errors[section][questionNumber];
                      let output = '#errors_' + section + '_' + questionNumber;

                      let formGroup = $(output).closest('.form-group');
                      let formControl = formGroup.find('.form-control');
                      let formCheckBox = formGroup.find('.form-check-input');
                      let formRange = formGroup.find('[type="range"]');
                      let formNumber = formGroup.find('[type="number"]');

                      let errorsHtml = errorsTemplate({error: error});
                      $(output).html(errorsHtml);

                      if (formControl) {
                        formControl.addClass('is-invalid');
                      }
                      if (formCheckBox) {
                        formGroup.addClass('is-invalid');
                        formCheckBox.addClass('is-invalid');
                      }
                      if (formRange || formNumber) {
                        formRange.addClass('is-invalid');
                        formNumber.addClass('is-invalid');
                      }
                    });
                  });
                  $( '#error-alert' ).html( bannerTemplate() );
                } else {
                  window.location.href = "http://localhost:8000/success.php";
                }
                $( '.can-valid:not(.is-invalid)' ).addClass( 'is-valid' );
                $( '.form-group.can-valid.is-valid .success-wrapper' ).html( successTemplate() );
            });
          })
        });

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