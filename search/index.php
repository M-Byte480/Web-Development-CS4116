<?php
// Validate is user logged in
require_once(__DIR__ . '/../validator_functions.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php require_once(__DIR__ . '/../css_binding.php'); ?>

    <title>PubClub Admin</title>
</head>
<body>

<?php require_once(__DIR__ . '/../NavBar/index.php'); ?>

<form action="search-results.php" method="post">
    <div class="container">
        <div class="row">
            <div class=" col-sm-12 col-md-4 bg-light p-3 border bg-blue">
                <div class="gender">
                    <?php
                    require_once(__DIR__ . '/../enums/gender.php');
                    $refl = new ReflectionClass(Gender::class);

                    foreach ($refl->getConstants() as $gender => $value) {
                        ?>
                        <div class="d-flex ">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="<?= $gender ?>"
                                       name="<?= $gender ?>" value="true">
                                <label class="form-check-label increased-font"
                                       for="<?= $gender ?>"><?= $gender ?></label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="age">
                    <label id="output3" for="lower">Minimum Age:</label>
                    <input type="range" class="form-range width-100" min="18" max="99"
                           step="1" value="18" name="age1"
                           id="lower">
                    <label id="output4" for="upper">Maximum Age:</label>
                    <input type="range" class="form-range width-100" min="18"
                           max="99" step="1" value="99" name="age2"
                           id="upper">

                    Min:
                    <output id="output1"></output>
                    Max:
                    <output id="output2"></output>

                </div>
            </div>
            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="go-to-beverages ">
                    <?php
                    require_once(__DIR__ . '/../database/repositories/beverages.php');
                    $beverages_from_db = get_all_beverages();
                    foreach ($beverages_from_db as $beverage) {
                        ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="<?= $beverage ?>"
                                   name="<?= $beverage ?>" value="true">
                            <label class="form-check-label increased-font"
                                   for="<?= $beverage ?>"><?= $beverage ?></label>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">

            <?php
            require_once(__DIR__ . '/../database/repositories/interests.php');
            $interests_from_db = get_all_interests();

            $len = count($interests_from_db);
            $first_half = array_slice($interests_from_db, 0, $len / 2);
            $second_half = array_slice($interests_from_db, $len / 2);
            ?>
            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="interests">
                    <?php
                    foreach ($interests_from_db as $interest) {
                        ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="<?= $interest ?>"
                                   name="<?= $interest ?>" value="true">
                            <label class="form-check-label increased-font"
                                   for="<?= $interest ?>"><?= $interest ?></label>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3 static bottom-left">SEARCH 🔍</button>
</form>

<script>
    // Help from : https://www.impressivewebs.com/onchange-vs-oninput-for-range-sliders/
    let lowerAge = document.getElementById('lower'), lowerOutput = document.querySelector('#output1');
    let upperAge = document.getElementById('upper'), upperOutput = document.querySelector('#output2');

    lowerOutput.innerHTML = lowerAge.value;
    upperOutput.innerHTML = upperAge.value;

    let minimumAgeTag = document.querySelector('#output3');
    let maximumAgeTag = document.querySelector('#output4');

    lowerAge.addEventListener('input', function () {
        lowerOutput.innerHTML = lowerAge.value;
        flipAgesIfLowerIsGreater();
    }, false);

    upperAge.addEventListener('input', function () {
        upperOutput.innerHTML = upperAge.value;
        flipAgesIfLowerIsGreater();
    }, false);

    function flipAgesIfLowerIsGreater() {
        if (parseInt(lowerAge.value) >= parseInt(upperAge.value)) {
            lowerOutput.innerHTML = upperAge.value;
            upperOutput.innerHTML = lowerAge.value;

            maximumAgeTag.innerHTML = 'Minimum Age:';
            minimumAgeTag.innerHTML = 'Maximum Age:';
        } else {
            minimumAgeTag.innerHTML = 'Minimum Age:';
            maximumAgeTag.innerHTML = 'Maximum Age:';
        }
    }
</script>
</body>
</html>