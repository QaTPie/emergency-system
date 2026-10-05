<?php
session_start();
require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/accounts.php';

$errors    = [];
$oldEmail  = '';
$oldPass   = '';
$oldRepeat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldEmail  = trim($_POST['email'] ?? '');
    $oldPass   = $_POST['password'] ?? '';
    $oldRepeat = $_POST['password_repeat'] ?? '';

    // Required Field Validation + Email Addresses + Numbers + confirmation
    $errors['email'] = required_field($oldEmail, 'Email')
                    ?: validate_email($oldEmail, 'Email');

    $errors['password'] = required_field($oldPass, 'New Password')
                       ?: validate_password_length($oldPass, 'New Password')
                       ?: validate_password_has_number($oldPass, 'New Password');

    $errors['password_repeat'] = required_field($oldRepeat, 'Repeat Password')
                              ?: validate_password_match($oldPass, $oldRepeat);

    $errors = array_filter($errors);

    if (!$errors) {
        if (accounts_update_password($oldEmail, $oldPass)) {
            $_SESSION['flash'] = 'Password updated. Please log in with your new password.';
            header('Location: index.php');
            exit;
        }

        $errors['email'] = 'No account was found with that email address.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenix Safety - Retrieve an Account</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <main class="container">
        <!-- ============ Form side ============ -->
        <section class="pane pane--reset">
            <div class="auth auth--reset">
                <h1>Retrieve an Account</h1>

                <!-- novalidate: the instructor's checklist is enforced server-side -->
                <form method="POST" action="" autocomplete="on" novalidate>
                    <div class="field-group">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email"
                               value="<?= old('email', $oldEmail) ?>"
                               aria-describedby="email-error">
                        <?php field_error($errors, 'email'); ?>
                    </div>

                    <div class="field-group">
                        <label for="password">New Password</label>
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

                    <div class="field-group">
                        <label for="password_repeat">Repeat Password</label>
                        <div class="pass-wrap">
                            <input id="password_repeat" name="password_repeat" type="password"
                                   aria-describedby="password-repeat-error">
                            <button type="button" class="toggle-pass" data-target="password_repeat"
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
                        <?php field_error($errors, 'password_repeat'); ?>
                    </div>

                    <button type="submit" class="pill-btn">Login</button>
                    <a class="pill-link" href="index.php">Back</a>
                </form>
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
