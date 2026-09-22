"use strict";
$(function () {
  $("#investor-login-form").submit(function (event) {
    let username = $("#investor-login-form input[name=mobile_no]").val();
    let password = $("#investor-login-form input[name=password]").val();
    event.preventDefault();

    if (username == "") {
      showErrorMessage("Mobile number is required");
      return false;
    } else if (password == "") {
      showErrorMessage("Password is required");
      return false;
    }
    showAjaxLoader();
    axios
      .post($(this).data("action"), new FormData($(this).get(0)))
      .then(function (response) {
        // console.log(response);
        if (!response.data.status) {
          showErrorMessage(response.data.message);
        } else {
          if (response.data.hasOwnProperty("view")) {
            $("#loginContent").html(response.data.view);
          } else {
            location.reload();
          }
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
