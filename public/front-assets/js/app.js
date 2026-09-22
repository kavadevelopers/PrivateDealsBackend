"use strict";
var regxForPassword = new RegExp(
  "^.(?=.{8,})(?=.[A-Z])(?=.[a-zA-Z])(?=.\\d)|(?=.[!@#$&]).*$"
);
$(function () {
  $(".details").click(function () {
    $(this).toggleClass("btn_active");
    $(this).children("i").toggleClass("arrow_rotate");
    if ($(this).hasClass("btn_active")) {
      $(this).children("span").html("Hide All");
    } else {
      $(this).children("span").html("Show All");
    }
  });
  $(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    $("#modalConfirm p").html("You want to delete this?");
    $("#modalConfirm .okay_btn").attr("href", $(this).attr("href"));
    $("#modalConfirm").modal("show");
  });
  $(document).on("click", ".btn-confirm", function (e) {
    e.preventDefault();
    $("#modalConfirm p").html($(this).data("message"));
    $("#modalConfirm .okay_btn").attr("href", $(this).attr("href"));
    $("#modalConfirm").modal("show");
  });

  $("#modalConfirm").on("shown.bs.modal", function (e) {
    $("#modalConfirm svg.warning").addClass("toggle");
  });

  $("#modalConfirm").on("hidden.bs.modal", function () {
    $("#modalConfirm svg.warning").removeClass("toggle");
  });

  $(document).on("click", ".inline-readmore", function (event) {
    if ($(this).prev().is(":visible")) {
      $(this).prev(".full-string-span").hide();
      $(this).html("<small>...more</small>");
    } else {
      $(this).prev(".full-string-span").show();
      $(this).html("<small> less</small>");
    }
    event.preventDefault();
  });

  $(document).on("click", ".read-more-popup-btn", function (event) {
    event.preventDefault();
    $("#modalReadmore p.info_body").html($(this).data("full"));
    $("#modalReadmore").modal("show");
  });

  let swiper = new Swiper(".feature-swiper", {
    loop: true,
    parallax: true,
    autoplay: true,
    speed: 5000,
    pauseOnMouseEnter: true,
    disableOnInteraction: true,
    nextButton: ".swiper-button-next",
    prevButton: ".swiper-button-prev",
    slidesPerView: 4,
    paginationClickable: true,
    spaceBetween: 20,
    breakpoints: {
      1920: {
        slidesPerView: 4,
        spaceBetween: 20,
      },
      1028: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      760: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      550: {
        slidesPerView: 1,
        spaceBetween: 15,
      },
    },
  });

  $(".feature-swiper").on("mouseenter", function (e) {
    swiper.stopAutoplay();
  });
  $(".feature-swiper").on("mouseleave", function (e) {
    swiper.startAutoplay();
  });

  $(".lazy").Lazy({
    delay: 10,
    afterLoad: function (element) {
      element[0].classList.remove("shimmer");
    },
    onError: function (element) {
      element[0].src = "/core/placeholders/no-image.png";
      element[0].classList.remove("shimmer");
    },
    beforeLoad: function (element) {
      // console.log(element[0].getAttribute("data-src"));
    },
  });

  $(".text_dynamic ul li").each(function () {
    $(this).prepend(`<i class="fa-solid fa-circle-check"></i>`);
  });
  $(".text_dynamic ul li ul li i").each(function () {
    $(this).addClass(`fa-circle-dot`);
    $(this).removeClass(`fa-circle-check`);
  });
  $(".text_dynamic ul li ul li ul li i").each(function () {
    $(this).addClass(`fa-arrow-right`);
    $(this).removeClass(`fa-circle-dot`);
    $(this).removeClass(`fa-circle-check`);
  });

  $(document).on(
    "click",
    ".show-hide-password .span-viewpassword",
    function (e) {
      e.preventDefault();
      parent = $(this).closest(".show-hide-password");
      if (parent.find("input").attr("type") == "text") {
        parent.find("input").attr("type", "password");
        $(this).addClass("fa-eye");
        $(this).removeClass("fa-eye-slash");
      } else if (parent.find("input").attr("type") == "password") {
        parent.find("input").attr("type", "text");
        $(this).addClass("fa-eye-slash");
        $(this).removeClass("fa-eye");
      }
    }
  );

  $(document).on("click", ".uploadPaymentReceipt", function (e) {
    e.preventDefault();
    $("#modalUploadPaymentReceipt label").html(
      "Select " + $(this).data("title") + ' <span class="required">*</span>'
    );
    $("#modalUploadPaymentReceipt input[name=transaction_id]").val(
      $(this).data("id")
    );
    $("#modalUploadPaymentReceipt").modal("show");
  });

  flatpickr(".datetimepicker", {
    enableTime: true,
    dateFormat: "d-m-Y h:i K",
    minDate: "today",
    time_24hr: false,
    minuteIncrement: 10,
  });
});

function showErrorMessage(message, type, url = "", buttonName = "") {
  if (url == "") {
    if (type == "success") {
      $("#modalSuccess p").html(message);
      $("#modalSuccess").modal("show");
    } else {
      $("#modalError p").html(message);
      $("#modalError").modal("show");
    }
  } else {
    let icon = "";
    if (type == "success") {
      icon =
        '<svg id="failureAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70">';
      icon +=
        '<circle id="failureAnimationCircle" cx="35" cy="35" r="24" stroke="#ED1C24" stroke-width="3" stroke-linecap="round" fill="transparent" />';
      icon +=
        '<polyline class="failureAnimationCheckLine" stroke="#ED1C24" stroke-width="3" points="25,25 45,45" fill="transparent" />';
      icon +=
        '<polyline class="failureAnimationCheckLine" stroke="#ED1C24" stroke-width="3" points="45,25 25,45" fill="transparent" />';
      icon += "</svg>";
      $("#modalCommonDoubleButton .success_icon").html(icon);
      $("#modalCommonDoubleButton .modal-title").html("Success");
    } else {
      icon =
        '<svg id="failureAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 70 70">';
      icon +=
        '<circle id="failureAnimationCircle" cx="35" cy="35" r="24" stroke="#ED1C24" stroke-width="3" stroke-linecap="round" fill="transparent" />';
      icon +=
        '<polyline class="failureAnimationCheckLine" stroke="#ED1C24" stroke-width="3" points="25,25 45,45" fill="transparent" />';
      icon +=
        '<polyline class="failureAnimationCheckLine" stroke="#ED1C24" stroke-width="3" points="45,25 25,45" fill="transparent" />';
      icon += "</svg>";
      $("#modalCommonDoubleButton .success_icon").html(icon);
      $("#modalCommonDoubleButton .modal-title").html("Error");
    }
    $("#modalCommonDoubleButton p").html(message);
    $("#modalCommonDoubleButton").modal("show");
    if (buttonName != "") {
      $("#modalCommonDoubleButton .ok-btn").html(buttonName);
    }
    $("#modalCommonDoubleButton .ok-btn").attr("href", url);
  }
}

function showAjaxLoader(state = true) {
  if (state) {
    $("#ajaxLoad").show();
  } else {
    $("#ajaxLoad").hide();
  }
}
const videos = document.querySelectorAll(".card_video");
videos.forEach((video) => {
  video.addEventListener("mouseover", function () {
    this.play();
  });
  video.addEventListener("mouseout", function () {
    this.load();
  });
  video.addEventListener("touchstart", function () {
    this.play();
  });
  video.addEventListener("touchend", function () {
    this.load();
  });
});
