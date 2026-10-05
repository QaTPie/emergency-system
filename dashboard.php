<?php
session_start();

// The dashboard is only available to a signed-in user.
if (empty($_SESSION['user_email'])) {
    header('Location: index.php');
    exit;
}

$name      = $_SESSION['user_name'] ?? 'User';
$firstName = trim(strtok($name, ' ')) ?: 'User';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenix Rising - Dashboard</title>
    <link rel="stylesheet" href="assets/dashboard.css">
</head>

<body>
    <!-- ================= Sidebar ================= -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <span class="brand-mark">
                <img src="assets/phoenixlogocircle.png"
                    alt="Disaster Risk Reduction &amp; Management Unit seal">
            </span>
            <span class="brand-names">
                <span class="brand-top">PHOENIX</span>
                <span class="brand-bottom">RISING</span>
            </span>
        </div>

        <p class="brand-sub">Emergency Reporting System</p>

        <nav class="nav" aria-label="Main">
            <a class="nav-item is-active" href="dashboard.php">
                <svg class="nav-ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3.1 2.4 11.2h2.7v9.3h5.1v-5.9h3.4v5.9h5.1v-9.3h2.7z" />
                </svg>
                <span>Home</span>
            </a>

            <a class="nav-item" href="#">
                <img class="nav-ico" src="assets/alertemergency.png" alt="">
                <span>Report Emergency</span>
            </a>

            <a class="nav-item" href="#">
                <svg class="nav-ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#f2f2f2"
                        d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 0 1 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.7.1.4 0 .8-.2 1.1z" />
                </svg>
                <span>Emergency Contacts</span>
            </a>

            <a class="nav-item" href="#">
                <svg class="nav-ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#f2f2f2"
                        d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 0 0 .12-.61l-1.92-3.32a.49.49 0 0 0-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.48.48 0 0 0-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96a.49.49 0 0 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58a.49.49 0 0 0-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" />
                </svg>
                <span>Settings</span>
            </a>
        </nav>

        <a class="nav-item nav-logout" href="logout.php">
            <svg class="nav-ico" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#f2f2f2"
                    d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8v-2H4z" />
            </svg>
            <span>Log Out</span>
        </a>
    </aside>

    <!-- ================= Main ================= -->
    <div class="main">
        <header class="topbar">
            <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle navigation" aria-expanded="true">
                <span></span><span></span><span></span>
            </button>
        </header>

        <!-- Welcome banner -->
        <section class="welcome">
            <div class="welcome-text">
                <h1>Welcome!</h1>
                <p>Report emergencies to keep our campus safe.</p>
            </div>

            <div class="greeting">
                <strong>Good Day, <?= htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8') ?>!</strong>
                <span>Stay aware. Help is one report away.</span>
            </div>

            <a class="report-btn" href="#">
                <img class="report-ico" src="assets/alarm.png" alt="">
                <span>REPORT AN EMERGENCY</span>
                <svg class="arrow" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M2.5 10.4h12.9l-4.3-4.3 1.6-1.6 6.8 6.8-6.8 6.8-1.6-1.6 4.3-4.3H2.5z" />
                </svg>
            </a>
        </section>

        <div class="sections">
            <!-- Stat cards -->
            <div class="stats">
                <article class="stat stat--red">
                    <span class="stat-label">Active Emergencies</span>
                    <span class="stat-value">0</span>
                    <svg class="stat-ico" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.2 4.6a3.8 3.8 0 0 1 7.6 0v6.6H8.2z" fill="#e63946" />
                        <rect x="5.6" y="11.4" width="12.8" height="3.8" rx="1.4" fill="#d9d9d9" />
                        <rect x="7.4" y="15.8" width="9.2" height="3" rx="1.2" fill="#bdbdbd" />
                    </svg>
                </article>

                <article class="stat stat--blue">
                    <span class="stat-label">My Reports</span>
                    <span class="stat-value">0</span>
                    <svg class="stat-ico" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4.5" y="2.5" width="13" height="17" rx="2" fill="#dbe7f6" stroke="#4a7fbe" stroke-width="1.6" />
                        <g stroke="#4a7fbe" stroke-width="1.7" stroke-linecap="round">
                            <path d="M7.5 7h7" /><path d="M7.5 11h7" /><path d="M7.5 15h4.5" />
                        </g>
                    </svg>
                </article>

                <article class="stat stat--sand">
                    <span class="stat-label">Pending Reports</span>
                    <span class="stat-value">0</span>
                    <svg class="stat-ico" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" fill="none" stroke="#a8954f" stroke-width="1.8" />
                        <path d="M12 6.8V12l3.4 2.2" fill="none" stroke="#a8954f" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </article>

                <article class="stat stat--green">
                    <span class="stat-label">Resolved Reports</span>
                    <span class="stat-value">0</span>
                    <svg class="stat-ico" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" fill="#2f9e4f" />
                        <path d="M7.4 12.3l3.1 3.1 6-6.2" fill="none" stroke="#fff" stroke-width="2.3"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </article>
            </div>

            <!-- Alerts + help -->
            <div class="mid">
                <div class="alerts">
                    <p class="eyebrow">STAY INFORMED</p>
                    <h2>Current Campus Alerts</h2>

                    <div class="alert alert--red">
                        <span class="alert-dot"></span>
                        <span class="alert-body">
                            <span class="alert-label">Emergency Alert</span>
                            <span class="alert-value">NONE</span>
                        </span>
                    </div>

                    <div class="alert alert--sand">
                        <span class="alert-dot"></span>
                        <span class="alert-body">
                            <span class="alert-label">Safety Advisory</span>
                            <span class="alert-value">NONE</span>
                        </span>
                    </div>
                </div>

                <div class="help">
                    <p class="help-title">NEED IMMEDIATE HELP?</p>
                    <img class="help-button" src="assets/pushbutton.png" alt="Emergency push button">
                    <p class="help-caption">PUSH THE BUTTON</p>
                </div>
            </div>

            <!-- Recent reports -->
            <section class="reports">
                <p class="eyebrow">YOUR ACTIVITY</p>
                <h2>Recent Reports</h2>

                <div class="report-head">
                    <span>Reports</span>
                    <span>Location</span>
                    <span>Date</span>
                    <span>Status</span>
                </div>

                <div class="report-empty">
                    <svg class="empty-ico" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14 2.5H7a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.5z"
                            fill="none" stroke="#3d3d3d" stroke-width="1.6" stroke-linejoin="round" />
                        <path d="M14 2.5v5h5" fill="none" stroke="#3d3d3d" stroke-width="1.6"
                            stroke-linejoin="round" />
                        <g stroke="#3d3d3d" stroke-width="1.6" stroke-linecap="round">
                            <path d="M8.5 12.5h7" /><path d="M8.5 16h7" />
                        </g>
                    </svg>
                    <p class="empty-title">No reports submitted yet</p>
                    <p class="empty-sub">Your submitted report will appear here</p>
                </div>
            </section>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('menuBtn');
            var narrow = window.matchMedia('(max-width: 900px)');

            function apply(open) {
                document.body.classList.toggle('nav-open', open);
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            apply(narrow.matches);

            btn.addEventListener('click', function () {
                apply(!document.body.classList.contains('nav-open'));
            });

            narrow.addEventListener('change', function (e) { apply(e.matches); });
        })();
    </script>
</body>

</html>
