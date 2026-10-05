# Phoenix Rising — Emergency Reporting System

Login, Sign-up, password reset and dashboard for the propose project.

## Requirements

- **PHP 8.0 or newer**
- **No database needed** — accounts are stored in `accounts.json`, which is created
  automatically on the first sign-up.

## How to run it

Pick **one** of the options below. You must run it through a web server — opening
`index.php` straight from the file explorer will **not** work.

### Option 1 — PHP built-in server (fastest)

Open a terminal in the project folder (`Ctrl+`` ` in VS Code) and run:

```
php -S localhost:8000
```

Then open **http://localhost:8000/index.php** in your browser.

Leave the terminal running while you use the site. Stop it with `Ctrl+C`.

> If the terminal says `'php' is not recognized` (Windows) or `command not found`
> (macOS/Linux), PHP isn't installed — use Option 2 instead.

### Option 2 — XAMPP / WAMP / Laragon

1. Copy this folder into your web root, e.g. `C:\xampp\htdocs\phoenix`
2. Start **Apache** from the XAMPP control panel
3. Open **http://localhost/phoenix/index.php**

## ⚠️ VS Code "Live Server" does not work

Live Server only serves plain HTML/CSS/JS — it does **not** execute PHP, so the
page will show up blank or as raw source code. Use Option 1 or Option 2 instead.

## Pages

| File | Purpose |
|---|---|
| `index.php` | Login |
| `signup.php` | Create an account |
| `forgot_password.php` | Reset a password |
| `dashboard.php` | Dashboard (redirects to login if not signed in) |
| `logout.php` | Sign out |

## Project structure

```
assets/
  style.css              shared styles (login / sign-up / reset)
  dashboard.css          dashboard styles
  password-toggle.js     show / hide password eye button
  phoenixr.png           phoenix logo (watermark + artwork side)
  phoenixlogocircle.png  DRRMU seal
  alarm.png              siren icon — REPORT AN EMERGENCY button
  alertemergency.png     sidebar "Report Emergency" icon
  pushbutton.png         "PUSH THE BUTTON" circle
accounts.php             account store (create / find / verify)
validation.php           field validation rules
accounts.json            created at runtime — holds registered users
```

## Validation rules (instructor checklist)

| Item | Where |
|---|---|
| Required Field Validation | every field, on all three forms |
| Validating Text Input | **Name** on Sign-up — letters, spaces, hyphens and apostrophes only |
| Validating Numbers | **Password** must contain at least one digit `0-9` (Sign-up *and* Login) |
| Validating Email Addresses | `FILTER_VALIDATE_EMAIL` + an explicit pattern, on all three forms |

## Notes

- Passwords are stored with `password_hash()` (bcrypt) and checked with
  `password_verify()` — never in plain text.
- The folder must be **writable** by the web server so PHP can create and update
  `accounts.json`.
- `accounts.json` is ignored by git so everyone gets a clean account list when they
  copy the project.
