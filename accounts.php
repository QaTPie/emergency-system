<?php
/**
 * Tiny file-backed account store (no database required).
 *
 * Passwords are never stored in plain text — they go through password_hash()
 * with PHP's PASSWORD_DEFAULT (bcrypt/argon2) and are checked with
 * password_verify().
 *
 * Data lives in accounts.json next to this file.
 */

const ACCOUNTS_FILE = __DIR__ . '/accounts.json';

/**
 * @return array<int, array{id:string,name:string,email:string,password:string,created_at:string}>
 */
function accounts_load(): array
{
    if (!is_file(ACCOUNTS_FILE)) {
        return [];
    }

    $raw = file_get_contents(ACCOUNTS_FILE);

    if ($raw === false || trim($raw) === '') {
        return [];
    }

    $data = json_decode($raw, true);

    return is_array($data) ? $data : [];
}

/**
 * @param array<int, array> $users
 */
function accounts_save(array $users): void
{
    $json = json_encode(
        array_values($users),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );

    if ($json === false) {
        return;
    }

    file_put_contents(ACCOUNTS_FILE, $json, LOCK_EX);
}

/**
 * @return array|null the matching account, or null when it does not exist
 */
function accounts_find_by_email(string $email): ?array
{
    $needle = strtolower(trim($email));

    foreach (accounts_load() as $user) {
        if (isset($user['email']) && strtolower($user['email']) === $needle) {
            return $user;
        }
    }

    return null;
}

function accounts_email_exists(string $email): bool
{
    return accounts_find_by_email($email) !== null;
}

/**
 * @return bool false when the email is already registered
 */
function accounts_create(string $name, string $email, string $password): bool
{
    if (accounts_email_exists($email)) {
        return false;
    }

    $users = accounts_load();

    $users[] = [
        'id'         => bin2hex(random_bytes(8)),
        'name'       => trim($name),
        'email'      => strtolower(trim($email)),
        'password'   => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('c'),
    ];

    accounts_save($users);

    return true;
}

/**
 * @return bool false when no account uses that email address
 */
function accounts_update_password(string $email, string $newPassword): bool
{
    $users  = accounts_load();
    $needle = strtolower(trim($email));
    $found  = false;

    foreach ($users as &$user) {
        if (isset($user['email']) && strtolower($user['email']) === $needle) {
            $user['password']   = password_hash($newPassword, PASSWORD_DEFAULT);
            $user['updated_at'] = date('c');
            $found = true;
            break;
        }
    }
    unset($user);

    if ($found) {
        accounts_save($users);
    }

    return $found;
}

/**
 * Verify credentials. Returns the account on success, null otherwise.
 */
function accounts_verify(string $email, string $password): ?array
{
    $user = accounts_find_by_email($email);

    if ($user === null) {
        return null;
    }

    return password_verify($password, $user['password']) ? $user : null;
}
