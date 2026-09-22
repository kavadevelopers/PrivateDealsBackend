(function () {
  const form = document.getElementById("pd-contact-form");
  if (!form) return;

  const status = document.getElementById("pd-contact-status");
  const submit = document.getElementById("pd-contact-submit");
  const submitLabel = submit ? submit.querySelector("span") : null;
  const defaultLabel = submitLabel ? submitLabel.textContent : "Send message";
  const endpoint = "https://www.shuruup.com/api/privatedeals/submit-data";

  function setStatus(message, kind) {
    if (!status) return;
    status.hidden = false;
    status.textContent = message;
    status.className = "pd-form-status pd-form-status--" + kind;
  }

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    const honey = form.querySelector('[name="_honey"]');
    if (honey && honey.value) return;

    if (submit) submit.disabled = true;
    if (submitLabel) submitLabel.textContent = "Sending…";
    setStatus("Sending your message…", "pending");

    const payload = {
      name: form.fullname.value.trim(),
      email: form.email.value.trim(),
      message: form.message.value.trim(),
      firm: form.firm.value.trim(),
      phone: form.number.value.trim(),
      subject: form.subject.value.trim(),
    };

    fetch(endpoint, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    })
      .then(function (response) {
        return response.text().then(function (text) {
          var data = {};
          try {
            data = text ? JSON.parse(text) : {};
          } catch (err) {
            data = { message: text };
          }
          return { httpOk: response.ok, data: data };
        });
      })
      .then(function (result) {
        const data = result.data || {};
        const ok =
          result.httpOk &&
          data.ok !== false &&
          data.success !== false &&
          data.success !== "false";
        const apiMessage = data.message || data.error || "";

        if (!ok) {
          throw new Error(apiMessage || "Could not send the message.");
        }

        form.reset();
        setStatus(
          apiMessage || "Message sent. We will reply to you at the email you entered.",
          "success"
        );
      })
      .catch(function (error) {
        setStatus(
          error.message || "Could not reach the mail API. Try again in a moment.",
          "error"
        );
      })
      .finally(function () {
        if (submit) submit.disabled = false;
        if (submitLabel) submitLabel.textContent = defaultLabel;
      });
  });
})();
