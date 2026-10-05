<?php
session_start();
require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/accounts.php';

$errors   = [];
$oldName  = '';
$oldEmail = '';
$oldPass  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldName  = trim($_POST['name'] ?? '');
    $oldEmail = trim($_POST['email'] ?? '');
    $oldPass  = $_POST['password'] ?? '';

    // Required Field Validation + Text Input + Email Addresses + Numbers
    $errors['name']     = required_field($oldName, 'Name')
                       ?: validate_text($oldName, 'Name');

    $errors['email']    = required_field($oldEmail, 'Email Address')
                       ?: validate_email($oldEmail, 'Email Address');

    $errors['password'] = required_field($oldPass, 'Set Password')
                       ?: validate_password_length($oldPass, 'Set Password')
                       ?: validate_password_has_number($oldPass, 'Set Password');

    $errors = array_filter($errors);

    if (!$errors) {
        if (accounts_email_exists($oldEmail)) {
            $errors['email'] = 'An account with that email address already exists.';
        } else {
            accounts_create($oldName, $oldEmail, $oldPass);

            $_SESSION['flash'] = 'Account created for ' . $oldName
                               . '. You can now log in with your email and password.';
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenix Safety - Sign Up</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <main class="container">
        <!-- ============ Form side ============ -->
        <section class="pane">
            <div class="auth">
                <h1>Create Your Account</h1>

                <!-- novalidate: the instructor's checklist is enforced server-side -->
                <form method="POST" action="" autocomplete="on" novalidate>
                    <div class="field-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text"
                               value="<?= old('name', $oldName) ?>"
                               aria-describedby="name-error">
                        <?php field_error($errors, 'name'); ?>
                    </div>

                    <div class="field-group">
                        <label for="email">Email Address</label>
                        <input id="email" name="email" type="email"
                               value="<?= old('email', $oldEmail) ?>"
                               aria-describedby="email-error">
                        <?php field_error($errors, 'email'); ?>
                    </div>

                    <div class="field-group">
                        <label for="password">Set Password</label>
                        <div class="pass-wrap">
                            <input id="password" name="password" type="password"
                                   aria-describedby="password-error">
                            <button type="button" class="toggle-pass" data-target="password"
                                aria-label="Show password" aria-pressed="false">
                                <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M1.9 12S5.6 5.2 12 5.2 22.1 12 22.1 12 18.4 18.8 12 18.8 1.9 12 1.9 12Z" />
                                    <circle cx="12" cy="12" r="3.2" />
                                </svg>
                                <svg class="eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M10.6 5.5A9.6 9.6 0 0 1 12 5.2c6.4 0 10.1 6.8 10.1 6.8a17.6 17.6 0 0 1-3.6 4.5" />
                                    <path d="M6.4 6.8A17.3 17.3 0 0 0 1.9 12s3.7 6.8 10.1 6.8a9.7 9.7 0 0 0 4.1-.9" />
                                    <path d="M10.2 10.2a2.6 2.6 0 0 0 3.6 3.6" />
                                    <path d="M3.2 3.2 20.8 20.8" />
                                </svg>
                            </button>
                        </div>
                        <?php field_error($errors, 'password'); ?>
                    </div>

                    <button type="submit" class="pill-btn">Sign Up</button>
                </form>

                <p class="alt-link">Already have an account? <a href="index.php">Log In</a></p>
            </div>
        </section>

        <!-- ============ Artwork side ============ -->
        <aside class="promo promo--right">
            <img class="promo-artwork" src="assets/phoenixr.png" alt="">
        </aside>
    </main>

    <script src="assets/password-toggle.js" defer></script>
</body>

</html>
