(function () {
  const form = document.getElementById("pd-login-form");
  if (!form) return;

  const status = document.getElementById("pd-login-status");
  const mobile = document.getElementById("mobile");
  const password = document.getElementById("password");
  const submit = document.getElementById("pd-login-submit");
  const submitLabel = submit ? submit.querySelector("span") : null;
  const defaultLabel = submitLabel ? submitLabel.textContent : "Log In";

  function showStatus(message) {
    if (!status) return;
    status.hidden = false;
    status.textContent = message;
  }

  function rejectLogin(message) {
    showStatus(message);
    if (submit) submit.disabled = false;
    if (submitLabel) submitLabel.textContent = defaultLabel;
  }

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const mobileValue = (mobile && mobile.value ? mobile.value : "").trim();
    const passwordValue = password && password.value ? password.value : "";

    if (!mobileValue) {
      rejectLogin("Please enter your mobile number.");
      if (mobile) mobile.focus();
      return;
    }

    if (!passwordValue) {
      rejectLogin("Please enter your password.");
      if (password) password.focus();
      return;
    }

    if (submit) submit.disabled = true;
    if (submitLabel) submitLabel.textContent = "Checking…";

    window.setTimeout(function () {
      rejectLogin(
        "This user is not registered. Private Deals access is invitation-only — Join us to request partner access."
      );
    }, 650);
  });
})();
