<?php
session_start();
require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/accounts.php';

$errors    = [];
$oldEmail  = '';
$notice    = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldEmail = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Required Field Validation + Email Addresses + Numbers
    $errors['email']    = required_field($oldEmail, 'Email')
                       ?: validate_email($oldEmail, 'Email');

    $errors['password'] = required_field($password, 'Password')
                       ?: validate_password_has_number($password, 'Password');

    $errors = array_filter($errors);

    if (!$errors) {
        $user = accounts_verify($oldEmail, $password);

        if ($user === null) {
            $errors['password'] = 'Incorrect email or password.';
        } else {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name']  = $user['name'];
            header('Location: dashboard.php');
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
    <title>Phoenix Safety - Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <main class="container">
        <!-- ============ Left panel ============ -->
        <section class="promo promo--left">
            <img class="promo-watermark" src="assets/phoenixr.png" alt="">
            <div class="promo-content">
                <h1>No Account Yet?<br>Create Now!</h1>
                <p>join us in keeping our campus safe!</p>
                <a class="signup-btn" href="signup.php">Sign Up</a>
            </div>
        </section>

        <!-- ============ Right panel ============ -->
        <section class="login<?= $notice !== '' ? ' login--notice' : '' ?>">
            <div class="login-inner">
                <?php if ($notice !== ''): ?>
                    <p class="form-notice form-notice--ok"><?= htmlspecialchars($notice, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <div class="seal">
                    <img src="assets/phoenixlogocircle.png"
                        alt="Disaster Risk Reduction &amp; Management Unit seal">
                </div>

                <h2>Your Safety Starts Here.</h2>

                <!-- novalidate: the instructor's checklist is enforced server-side -->
                <form method="POST" action="" autocomplete="on" novalidate>
                    <div class="field-group">
                        <div class="field">
                            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="7.2" r="5.4" fill="#141414" />
                                <path d="M12 13.4c-5.1 0-9.3 2.6-10 6a1.7 1.7 0 0 0 1.7 2.1h16.6a1.7 1.7 0 0 0 1.7-2.1c-.7-3.4-4.9-6-10-6Z"
                                    fill="#141414" />
                            </svg>
                            <input type="email" name="email" placeholder="Email"
                                value="<?= old('email', $oldEmail) ?>"
                                aria-label="Email">
                        </div>
                        <?php field_error($errors, 'email'); ?>
                    </div>

                    <div class="field-group">
                        <div class="field">
                            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.4 10.4V7.6a3.6 3.6 0 0 1 7.2 0v2.8" fill="none"
                                    stroke="#141414" stroke-width="2.9" stroke-linecap="round" />
                                <rect x="2.6" y="9.9" width="18.8" height="12.4" rx="2.6" fill="#141414" />
                                <circle cx="12" cy="15.2" r="1.9" fill="#fff" />
                                <rect x="11.1" y="15.6" width="1.8" height="4.7" rx=".9" fill="#fff" />
                            </svg>
                            <input id="password" type="password" name="password" placeholder="Password"
                                aria-label="Password">
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

                    <button type="submit" class="login-btn">LOGIN</button>
                </form>

                <p class="forgot"><a href="forgot_password.php">Forgot Password? Click Here.</a></p>
            </div>
        </section>
    </main>

    <script src="assets/password-toggle.js" defer></script>
</body>

</html>
