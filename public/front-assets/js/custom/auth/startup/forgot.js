"use strict";
$(function () {
  $("#startup-forgot-form").submit(function (event) {
    let mobile_no = $("#startup-forgot-form input[name=mobile_no]").val();
    event.preventDefault();
    if (mobile_no == "") {
      showErrorMessage("Mobile number is required");
      return false;
    }
    showAjaxLoader();
    axios
      .post($(this).data("action"), new FormData($(this).get(0)))
      .then(function (response) {
        if (response.data.hasOwnProperty("reset")) {
          location.reload();
          return false;
        }
        // console.log(response);
        if (!response.data.status) {
          showErrorMessage(response.data.message);
        } else {
          $("#forgetContent").html(response.data.view);
        }
        showAjaxLoader(false);
      })
      .catch(function (error) {
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("click", "#resend-otp-btn", function (e) {
    e.preventDefault();
    showAjaxLoader();
    axios
      .post($(this).data("action"))
      .then(function (response) {
        // console.log(response);
        if (response.data.hasOwnProperty("reset")) {
          location.reload();
          return false;
        }

        if (!response.data.status) {
          showErrorMessage(response.data.message);
        } else {
          showErrorMessage(response.data.message, "success");
        }
        showAjaxLoader(false);
      })
      .catch(function (error) {
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#verify-otp-form", function (event) {
    let otp = $("#verify-otp-form input[name=otp]").val();
    event.preventDefault();
    if (otp == "") {
      showErrorMessage("Verification code is required");
      return false;
    }
    showAjaxLoader();
    axios
      .post($(this).data("action"), new FormData($(this).get(0)))
      .then(function (response) {
        // console.log(response);
        if (response.data.hasOwnProperty("reset")) {
          location.reload();
          return false;
        }

        if (!response.data.status) {
          showErrorMessage(response.data.message);
        } else {
          $("#forgetContent").html(response.data.view);
        }
        showAjaxLoader(false);
      })
      .catch(function (error) {
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });

  $(document).on("submit", "#change-password-form", function (event) {
    let password = $("#change-password-form input[name=password]").val();
    let cpassword = $("#change-password-form input[name=cpassword]").val();
    event.preventDefault();
    if (password == "") {
      showErrorMessage("Password is required");
      return false;
    } else if (cpassword == "") {
      showErrorMessage("Confirm Password is required");
      return false;
    } else if (!regxForPassword.test(password)) {
      showErrorMessage(
        "Password should contain at least 1 upper case, 1 lower case, 1 numeric character, 1 special character and 8 characters long."
      );
      return false;
    } else if (password != cpassword) {
      showErrorMessage("Password and confirm password must be same.");
      return false;
    }

    showAjaxLoader();
    axios
      .post($(this).data("action"), new FormData($(this).get(0)))
      .then(function (response) {
        console.log(response);
        if (response.data.hasOwnProperty("reset")) {
          location.reload();
          return false;
        }

        if (!response.data.status) {
          showErrorMessage(response.data.message);
        } else {
          location.href = $("#change-password-form").data("redirect");
        }
        showAjaxLoader(false);
      })
      .catch(function (error) {
        showErrorMessage("Something went wrong");
        showAjaxLoader(false);
      });
  });
});
