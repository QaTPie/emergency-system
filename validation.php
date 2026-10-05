<?php
/**
 * Shared input validation for the Login / Sign-up / Forgot-password forms.
 *
 * Instructor's checklist:
 *   - Required Field Validation   -> required_field()
 *   - Validating Text Input       -> validate_text()
 *   - Validating Numbers          -> validate_password_has_number()
 *   - Validating Email Addresses  -> validate_email()
 *
 * Every validator returns an empty string on success, or a ready-to-print
 * message on failure, so the pages can do:
 *
 *     $errors['email'] = required_field($email, 'Email')
 *                     ?: validate_email($email);
 */

/**
 * Required Field Validation.
 */
function required_field(string $value, string $label): string
{
    return trim($value) === '' ? "{$label} is required." : '';
}

/**
 * Validating Text Input.
 *
 * Accepts letters (any script), spaces, hyphens, apostrophes and periods —
 * e.g. "Maria Clara", "Dela Cruz", "Jean-Luc".
 */
function validate_text(string $value, string $label, int $min = 2, int $max = 60): string
{
    $value = trim($value);

    if ($value === '') {
        return '';                       // already reported by required_field()
    }

    if (!preg_match("/^[\p{L}][\p{L} \-'.]*$/u", $value)) {
        return "{$label} must contain letters, spaces, hyphens or apostrophes only.";
    }

    $length = mb_strlen($value, 'UTF-8');

    if ($length < $min) {
        return "{$label} must be at least {$min} characters long.";
    }

    if ($length > $max) {
        return "{$label} must not exceed {$max} characters.";
    }

    return '';
}

/**
 * Validating Numbers.
 *
 * Applied to the password fields: a password must contain at least one
 * numeric digit (0-9) as well as letters.
 */
function validate_password_has_number(string $value, string $label = 'Password'): string
{
    if ($value === '') {
        return '';
    }

    if (!preg_match('/[0-9]/', $value)) {
        return "{$label} must contain at least one number (0-9).";
    }

    return '';
}

/**
 * Password length rule (used by Sign-up and Forgot-password).
 */
function validate_password_length(string $value, string $label = 'Password', int $min = 8): string
{
    if ($value === '') {
        return '';
    }

    if (strlen($value) < $min) {
        return "{$label} must be at least {$min} characters long.";
    }

    return '';
}

/**
 * The two password fields on Forgot-password must agree.
 */
function validate_password_match(string $value, string $other, string $label = 'Repeat Password'): string
{
    if ($value === '' || $other === '') {
        return '';
    }

    if ($value !== $other) {
        return "{$label} does not match the new password.";
    }

    return '';
}

/**
 * Validating Email Addresses.
 *
 * Uses PHP's FILTER_VALIDATE_EMAIL plus an explicit pattern so the rule is
 * visible to the reader (and survives environments where the filter is
 * unusually permissive).
 */
function validate_email(string $value, string $label = 'Email'): string
{
    $value = trim($value);

    if ($value === '') {
        return '';
    }

    $pattern = '/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/';

    if (filter_var($value, FILTER_VALIDATE_EMAIL) === false || !preg_match($pattern, $value)) {
        return "{$label} must be a valid address, e.g. name@example.com.";
    }

    return '';
}

/**
 * Echo a POST value back into the form, HTML-escaped.
 */
function old(string $key, ?string $value = null): string
{
    if ($value !== null) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    return htmlspecialchars($_POST[$key] ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Print the first error recorded for a field (or nothing when it is valid).
 */
function field_error(array $errors, string $key): void
{
    if (!empty($errors[$key])) {
        echo '<p class="field-error">' . htmlspecialchars($errors[$key], ENT_QUOTES, 'UTF-8') . '</p>';
    }
}
