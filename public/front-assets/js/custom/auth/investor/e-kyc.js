"use strict";
$(function () {
  $(document).on("click", ".btnVerifyAadhar", function (e) {
    e.preventDefault();
    showAjaxLoader();
    let $this = $(this);
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    axios
      .post($this.data("action"), {
        _token: csrf_token,
      })
      .then(function (response) {
        console.log(response);
        if (!response.data.status) {
          showErrorMessage(response.data.message);
          showAjaxLoader(false);
        } else {
          let localResponse = response;
          $("html, body").animate({ scrollTop: 0 }, "slow");
          var options = {
            environment: "production",
            callback: function (response) {
              if (response.hasOwnProperty("error_code")) {
                showErrorMessage("Please Try again");
                console.log("error occurred in process");
                showAjaxLoader(false);
                return false;
              }
              getAadharData(
                localResponse.data.entity_id,
                $this.data("getaction")
              );
              showAjaxLoader(false);
            },
            is_iframe: true,
            logo: $('meta[name="meta-logo"]').attr("content"),
            theme: {
              primaryColor: "#fd6e56",
              secondaryColor: "#21b7cd",
            },
          };
          var digio = new Digio(options);
          digio.init();
          digio.submit(
            response.data.entity_id,
            response.data.mobile,
            response.data.token
          );
        }
      })
      .catch(function (error) {
        showErrorMessage(error);
        showAjaxLoader(false);
      });
  });
});

function getAadharData(entity_id, url) {
  showAjaxLoader();
  var csrf_token = $('meta[name="csrf-token"]').attr("content");
  axios
    .post(url, {
      _token: csrf_token,
      entity_id: entity_id,
    })
    .then(function (response) {
      showAjaxLoader(false);
      if (!response.data.status) {
        showErrorMessage(response.data.message);
      } else {
        location.reload();
      }
    })
    .catch(function (error) {
      showErrorMessage(error);
      showAjaxLoader(false);
    });
}

function checkWhichSelected(val) {
  if (val == "ekyc") {
    $(".eKycContainer").show();
    $(".manualKycContainer").hide();
  } else {
    $(".manualKycContainer").show();
    $(".eKycContainer").hide();
  }
}
