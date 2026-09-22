$(function () {
  initClasses();
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

  $(".flat-datepicker").flatpickr({
    dateFormat: "d-m-Y",
  });

  $(".flat-datetimepicker").flatpickr({
    enableTime: true,
    dateFormat: "d-m-Y h:i K",
    minDate: "today",
    time_24hr: false,
    minuteIncrement: 10,
  });

  $(document).on("click", ".btn-delete", function (e) {
    if (!confirm("Are you sure you want to delete this item?")) {
      return false;
    }
  });

  $(document).on("input", ".input-number-words", function () {
    var number = $(this).val();
    var words = price_in_words(number);

    // Get the previous output element related to this input and remove it
    $(this).next(".wordsOutput").remove();

    // Append the words below the corresponding input field
    $('<div class="wordsOutput">' + words + "</div>").insertAfter($(this));
  });

  $(".lazy").Lazy({
    delay: 10,
    afterLoad: function (element) {
      element[0].classList.remove("shimmer");
    },
    onError: function (element) {
      element[0].classList.remove("shimmer");
      element[0].src = "/core/placeholders/no-image.png";
    },
    beforeLoad: function (element) {},
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

  $(document).on("change", ".checkAll", function () {
    const groupId = $(this).data("group-id");
    const isChecked = $(this).is(":checked");

    // Check/uncheck all checkboxes in the same group
    $(`.checkSingle[data-group-id="${groupId}"]`).prop("checked", isChecked);
  });

  $(document).on("click", ".checkSingle", function () {
    const groupId = $(this).data("group-id");
    const allChecked =
      $(`.checkSingle[data-group-id="${groupId}"]`).length ===
      $(`.checkSingle[data-group-id="${groupId}"]:checked`).length;

    // Update the "Select All" checkbox based on individual checkboxes
    $(`.checkAll[data-group-id="${groupId}"]`).prop("checked", allChecked);
  });

  if (typeof tinymce !== "undefined") {
    initTinyMce();
  }
});
function initTinyMce() {
  var options = { selector: ".kt_docs_tinymce_basic", height: "480" };

  if (KTThemeMode.getMode() === "dark") {
    options["skin"] = "oxide-dark";
    options["content_css"] = "dark";
  }
  tinymce.init(options);
}

function showSpinningLoader(state = true) {
  if (state) {
    $("#spinningLoader").show();
  } else {
    $("#spinningLoader").hide();
  }
}

function showErrorMessage(message, type, url = "", buttonName = "") {
  if (type == "success") {
    Swal.fire({
      text: message,
      icon: "success",
      buttonsStyling: false,
      confirmButtonText: "Ok, got it!",
      customClass: {
        confirmButton: "btn btn-primary",
      },
    });
  } else {
    Swal.fire({
      text: message,
      icon: "error",
      buttonsStyling: false,
      confirmButtonText: "Ok, got it!",
      customClass: {
        confirmButton: "btn btn-primary",
      },
    });
  }
}
function confirmAction({
  title = "Are you sure?",
  text = "This action cannot be undone!",
  icon = "warning",
  confirmButtonText = "Yes, proceed!",
  cancelButtonText = "Cancel",
  confirmButtonColor = "#d33",
  cancelButtonColor = "#3085d6",
  onConfirm,
}) {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonColor: confirmButtonColor,
    cancelButtonColor: cancelButtonColor,
    confirmButtonText: confirmButtonText,
    cancelButtonText: cancelButtonText,
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed && typeof onConfirm === "function") {
      onConfirm();
    }
  });
}
function initClasses() {
  $(".input-number-words").trigger("input");
}
