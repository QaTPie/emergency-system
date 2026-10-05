/**
 * Show / hide password toggle.
 *
 * Each button carries data-target="<id of the password input>". Clicking it
 * flips that input between type="password" and type="text" and swaps the eye
 * icon so the user can check what they typed before submitting.
 *
 * Nothing here touches the value or the server-side validation — it is purely
 * a display convenience, so the field still submits exactly as before.
 */
(function () {
    'use strict';

    function bindToggle(button) {
        var input = document.getElementById(button.getAttribute('data-target'));

        if (!input) {
            return;
        }

        button.addEventListener('click', function () {
            var nowVisible = input.type === 'password';

            input.type = nowVisible ? 'text' : 'password';
            button.classList.toggle('is-visible', nowVisible);
            button.setAttribute('aria-pressed', nowVisible ? 'true' : 'false');
            button.setAttribute('aria-label', nowVisible ? 'Hide password' : 'Show password');

            // Keep the caret in the field so typing can continue straight away.
            input.focus({ preventScroll: true });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var buttons = document.querySelectorAll('.toggle-pass');

        for (var i = 0; i < buttons.length; i++) {
            bindToggle(buttons[i]);
        }
    });
})();
