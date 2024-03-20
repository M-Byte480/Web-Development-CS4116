<?php
// Validate is user logged in
require_once(__DIR__ . '/../validators.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="styles.css">
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>PubClub Admin</title>
</head>
<body>
<?php
require_once(__DIR__ . '/../NavBar/index.php');
?>

<form action="search-results.php" method="post">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="drink-frequency">
                    Here is the drink-Frequency box
                </div>
            </div>
            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="age">
                    <input type="range" class="form-range width-100" min="18" max="99" step="1" value="18"
                           id="customRange3 lower">
                    <input type="range" class="form-range width-100" min="18" max="99" step="1" value="99"
                           id="customRange3 upper">

                    <label for="age">Age Range:</label>
                    <input type="text" id="age" class="form-control" disabled>
                    <script>
                        $('#lower').mdbRange({
                            single: {
                                active: true,
                                counting: true,
                                countingTarget: '#ex'
                            }
                        });
                    </script>
                </div>
            </div>
            <div class=" col-sm-12 col-md-4 bg-light p-3 border">
                <div class="gender">
                    <?php
                    require_once(__DIR__ . '/../enums/gender.php');
                    $refl = new ReflectionClass(Gender::class);

                    foreach ($refl->getConstants() as $gender => $value) {
                        ?>
                        <input type="checkbox" name="<?= $gender ?>" value="true">
                        <?php
                        echo $gender;
                        echo '<br>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="go-to-beverages ">
                    <?php
                    require_once(__DIR__ . '/../database/repositories/beverages.php');
                    $beverages_from_db = get_all_beverages();
                    foreach ($beverages_from_db as $beverage) {
                        ?>
                        <input type="checkbox" name="<?= $beverage ?>" value="true">
                        <?php
                        echo $beverage;
                        echo '<br>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 bg-light p-3 border">
                <div class="interests">
                    Here is the gender box
                </div>
            </div>
            <!--        <div class=" col-sm-12 col-md-4 bg-light p-3 border">-->
            <!--            <div class="hobbies">-->
            <!--                Here is the hobbies-->
            <!--            </div>-->
            <!--        </div>-->
        </div>
    </div>

    <input type="submit" name="formSubmit" value="Submit"/>

</form>
</body>
</html>