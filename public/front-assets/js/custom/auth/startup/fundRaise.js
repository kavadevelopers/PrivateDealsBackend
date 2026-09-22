"use strict";
$(function () {



  function responseManage(response) {
    if (response.data.hasOwnProperty("main")) {
      $("#mainRegisterContainer").html(response.data.main);
    } else {
      $("#registerFormContent").html(response.data.view);
    }
    window.scroll({
      top: 0,
      behavior: "smooth",
    });
  }
});
