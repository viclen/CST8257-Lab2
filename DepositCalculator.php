<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Deposit Calculator</title>

    <style>
        label {
            font-weight: bold;
        }

        input+label {
            font-weight: normal;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>
            Thank you,
            <?= $_POST['name'] ?>,
            for using our deposit calculator!
        </h1>

        <?php
        $errors = [];

        if (isset($_POST['principal-amount']) && $_POST['principal-amount']) {
            if ($_POST['principal-amount'] <= 0) {
                $errors[] = "Principal Amount must be greater than zero.";
            }
        } else {
            $errors[] = "Principal Amount must not be blank.";
        }
        if (isset($_POST['interest-rate']) && $_POST['interest-rate']) {
            if (is_numeric($_POST['interest-rate'])) {
                if ($_POST['interest-rate'] <= 0) {
                    $errors[] = "Interest Rate must be greater than zero.";
                }
            } else {
                $errors[] = "Interest Rate must be numeric.";
            }
        } else {
            $errors[] = "Interest Rate must not be blank.";
        }
        if (isset($_POST['years-to-deposit']) && $_POST['years-to-deposit']) {
            if (is_numeric($_POST['interest-rate'])) {
                if ($_POST['years-to-deposit'] <= 0 || $_POST['years-to-deposit'] > 20) {
                    $errors[] = "Years to Deposit must be between 1 and 20.";
                }
            } else {
                $errors[] = "Years to Deposit must be numeric.";
            }
        } else {
            $errors[] = "Years to Deposit must not be blank.";
        }
        if (!isset($_POST['name']) || !$_POST['name']) {
            $errors[] = "Name must not be blank.";
        }
        if (!isset($_POST['postal-code']) || !$_POST['postal-code']) {
            $errors[] = "Postal Code must not be blank.";
        }
        if (!isset($_POST['phone-number']) || !$_POST['phone-number']) {
            $errors[] = "Phone Number must not be blank.";
        }
        if (!isset($_POST['email']) || !$_POST['email']) {
            $errors[] = "Email must not be blank.";
        }
        if (isset($_POST['contact-method']) && $_POST['contact-method']) {
            if ($_POST['contact-method'] == "email") {
                $contact = "Our customer service will contact you at $_POST[email].";
            } else {
                $period = '';
                if (isset($_POST['morning'])) {
                    $period .= 'morning';
                }
                if (isset($_POST['afternoon'])) {
                    if ($period) $period .= ' or ';
                    $period .= 'afternoon';
                }
                if (isset($_POST['evening'])) {
                    if ($period) $period .= ' or ';
                    $period .= 'evening';
                }
                if ($period) {
                    $contact = "Our customer service will call you tomorrow $period at " . $_POST['phone-number'] . ".";
                } else {
                    $errors[] = "You must select at least one period of the day to contact.";
                }
            }
        } else {
            $errors[] = "You must select a contact method.";
        }

        if ($errors) {
            ?>
            <p>
                However we can not process your request because of the following input errors:
            </p>
            <ul>
                <?php
                    foreach ($errors as $msg) {
                        ?>
                    <li>
                        <?= $msg ?>
                    </li>
                <?php
                    }
                    ?>
            </ul>
        <?php
        } else {
            ?>
            <p>
                <?= $contact ?>
            </p>

            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Year</th>
                        <th>Principal at Year Start</th>
                        <th>Interest for the Year</th>
                    </tr>
                    <?php
                        $interest = $_POST['interest-rate'];
                        $amount = $_POST['principal-amount'];

                        for ($i = 1; $i <= $_POST['years-to-deposit']; $i++) {
                            ?>
                        <tr>
                            <td>
                                <?= $i ?>
                            </td>
                            <td>
                                $ <?= number_format($amount, 2) ?>
                            </td>
                            <td>
                                $ <?= number_format($amount * $interest / 100, 2) ?>
                            </td>
                        </tr>
                    <?php

                            $amount += $amount * $interest / 100;
                        }
                        ?>
                </table>
            </div>

        <?php
        }
        ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>