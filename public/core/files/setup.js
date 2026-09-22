"use strict";
// let temporaryData = (() => {
//   let data = {};
//   return {
//     set: (key, value) => {
//       data[key] = value;
//     },
//     get: (key) => {
//       return data[key];
//     },
//   };
// })();

function fileExAllowedWithSize(input, types, size, isAdmin = false) {
  if (input.files && input.files[0]) {
    var FileSize = input.files[0].size / 1024 / 1024; // in MB
    var extension = input.files[0].name.substring(
      input.files[0].name.lastIndexOf(".") + 1,
    );
    if (FileSize > size) {
      showErrorMessage("Maxiumum File Size Is " + size + " Mb.", "error");
      input.value = "";
      return false;
    } else {
      let typesAr = types.replaceAll(".", "").split(",");
      if (types == "*" || isInArray(typesAr, extension)) {
        return true;
      } else {
        showErrorMessage("Only Allowed " + types + " Extension", "error");
        input.value = "";
        return false;
      }
    }
  }
}

$(document).on("keydown", ".input-code", function (event) {
  const key = event.key;

  if (
    /^[0-9\-]$/.test(key) ||
    ["Backspace", "Tab", "ArrowLeft", "ArrowRight", "Delete", "Enter"].includes(
      key,
    ) ||
    event.ctrlKey ||
    event.metaKey
  ) {
    return;
  }

  event.preventDefault();
});

$(document).on("paste", ".input-code", function (event) {
  const pasteData = (event.originalEvent || event).clipboardData.getData(
    "text",
  );
  if (!/^[0-9\-]+$/.test(pasteData)) {
    event.preventDefault();
  }
});

$(document).on("input", ".input-code", function () {
  const cleanValue = $(this)
    .val()
    .replace(/[^0-9\-]/g, "");
  $(this).val(cleanValue);
});

$(document).on("keydown", ".input-number", function (event) {
  if (
    (event.keyCode >= 48 && event.keyCode <= 57) ||
    (event.keyCode >= 96 && event.keyCode <= 105) ||
    event.keyCode == 8 ||
    event.keyCode == 9 ||
    event.keyCode == 37 ||
    event.keyCode == 39 ||
    event.keyCode == 46 ||
    ((event.ctrlKey || event.metaKey) && event.keyCode == 82) || // Allow Ctrl/Cmd + R
    (event.shiftKey && (event.keyCode == 37 || event.keyCode == 39)) // Allow Shift + Arrow keys
  ) {
  } else {
    if (event.shiftKey == true) {
      event.preventDefault();
    }

    if (
      (event.ctrlKey || event.metaKey) &&
      (event.keyCode == 67 || event.keyCode == 86 || event.keyCode == 88)
    ) {
      event.preventDefault();
    } else if (event.keyCode == 13) {
      // Do stuff if Enter is pressed
    } else {
      event.preventDefault();
    }
  }
});

$(document).on("keydown", ".input-decimal-number", function (event) {
  // Allow numeric keys, backspace, tab, delete, arrow keys, Ctrl/Cmd+R, Ctrl/Cmd+C, Ctrl/Cmd+V, Ctrl/Cmd+X, Enter, and decimal point
  if (
    (event.keyCode >= 48 && event.keyCode <= 57) || // 0-9
    (event.keyCode >= 96 && event.keyCode <= 105) || // Numpad 0-9
    event.keyCode == 8 || // Backspace
    event.keyCode == 9 || // Tab
    event.keyCode == 37 || // Left arrow
    event.keyCode == 39 || // Right arrow
    event.keyCode == 46 || // Delete
    ((event.ctrlKey || event.metaKey) && event.keyCode == 82) || // Ctrl/Cmd + R
    ((event.ctrlKey || event.metaKey) && event.keyCode == 67) || // Ctrl/Cmd + C
    ((event.ctrlKey || event.metaKey) && event.keyCode == 86) || // Ctrl/Cmd + V
    ((event.ctrlKey || event.metaKey) && event.keyCode == 88) || // Ctrl/Cmd + X
    event.keyCode == 13 || // Enter
    event.keyCode == 190 ||
    event.keyCode == 110 // Decimal point (.)
  ) {
    // Allow Shift + Arrow keys
    if (event.shiftKey && (event.keyCode == 37 || event.keyCode == 39)) {
      return;
    }

    if (
      (event.ctrlKey || event.metaKey) &&
      (event.keyCode == 67 || event.keyCode == 86 || event.keyCode == 88)
    ) {
      event.preventDefault();
    }

    // Prevent multiple decimal points
    const value = $(this).val();
    if (
      (event.keyCode == 190 || event.keyCode == 110) &&
      value.indexOf(".") !== -1
    ) {
      event.preventDefault();
    }
  } else {
    // Prevent other keys
    event.preventDefault();
  }
});

$(document).on("keydown", ".input-version-number", function (event) {
  // Allow numeric keys, backspace, tab, delete, arrow keys, Ctrl/Cmd+R, Ctrl/Cmd+C, Ctrl/Cmd+V, Ctrl/Cmd+X, Enter, and multiple decimal points (for version format like 3.0.3)
  if (
    (event.keyCode >= 48 && event.keyCode <= 57) || // 0-9
    (event.keyCode >= 96 && event.keyCode <= 105) || // Numpad 0-9
    event.keyCode == 8 || // Backspace
    event.keyCode == 9 || // Tab
    event.keyCode == 37 || // Left arrow
    event.keyCode == 39 || // Right arrow
    event.keyCode == 46 || // Delete
    ((event.ctrlKey || event.metaKey) && event.keyCode == 82) || // Ctrl/Cmd + R
    ((event.ctrlKey || event.metaKey) && event.keyCode == 67) || // Ctrl/Cmd + C
    ((event.ctrlKey || event.metaKey) && event.keyCode == 86) || // Ctrl/Cmd + V
    ((event.ctrlKey || event.metaKey) && event.keyCode == 88) || // Ctrl/Cmd + X
    event.keyCode == 13 || // Enter
    event.keyCode == 190 ||
    event.keyCode == 110 // Decimal point (.) - allows multiple dots for version numbers
  ) {
    // Allow Shift + Arrow keys
    if (event.shiftKey && (event.keyCode == 37 || event.keyCode == 39)) {
      return;
    }
  } else {
    // Prevent other keys
    event.preventDefault();
  }
});

$(document).on("keydown", ".input-minus-decimal-number", function (event) {
  const value = $(this).val();

  // Allow numeric keys, backspace, tab, delete, arrow keys, minus sign, Ctrl/Cmd+R, Ctrl/Cmd+C, Ctrl/Cmd+V, Ctrl/Cmd+X, Enter, and decimal point
  if (
    (event.keyCode >= 48 && event.keyCode <= 57) || // 0-9
    (event.keyCode >= 96 && event.keyCode <= 105) || // Numpad 0-9
    event.keyCode == 8 || // Backspace
    event.keyCode == 9 || // Tab
    event.keyCode == 37 || // Left arrow
    event.keyCode == 39 || // Right arrow
    event.keyCode == 46 || // Delete
    ((event.ctrlKey || event.metaKey) && event.keyCode == 82) || // Ctrl/Cmd + R
    ((event.ctrlKey || event.metaKey) && event.keyCode == 67) || // Ctrl/Cmd + C
    ((event.ctrlKey || event.metaKey) && event.keyCode == 86) || // Ctrl/Cmd + V
    ((event.ctrlKey || event.metaKey) && event.keyCode == 88) || // Ctrl/Cmd + X
    event.keyCode == 13 || // Enter
    event.keyCode == 190 || // Decimal point (.)
    event.keyCode == 110 || // Numpad decimal point
    event.keyCode == 189 || // Minus sign (-)
    event.keyCode == 109 // Numpad minus (-)
  ) {
    // Allow Shift + Arrow keys
    if (event.shiftKey && (event.keyCode == 37 || event.keyCode == 39)) {
      return;
    }

    // Prevent multiple decimal points
    if ((event.keyCode == 190 || event.keyCode == 110) && value.includes(".")) {
      event.preventDefault();
    }

    // Prevent minus sign anywhere except at the start
    if ((event.keyCode == 189 || event.keyCode == 109) && value.length > 0) {
      event.preventDefault();
    }
  } else {
    // Prevent other keys
    event.preventDefault();
  }
});

function isInArray(array, search) {
  return array.indexOf(search) >= 0;
}

function getRandomColorCodes(length) {
  var letters = "0123456789ABCDEF";

  let colors = [];
  for (let i = 0; i < length; i++) {
    var color = "#";
    for (var j = 0; j < 6; j++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    colors.push(color);
  }

  return colors;
}

function price_in_words(price) {
  var sglDigit = [
      "Zero",
      "One",
      "Two",
      "Three",
      "Four",
      "Five",
      "Six",
      "Seven",
      "Eight",
      "Nine",
    ],
    dblDigit = [
      "Ten",
      "Eleven",
      "Twelve",
      "Thirteen",
      "Fourteen",
      "Fifteen",
      "Sixteen",
      "Seventeen",
      "Eighteen",
      "Nineteen",
    ],
    tensPlace = [
      "",
      "Ten",
      "Twenty",
      "Thirty",
      "Forty",
      "Fifty",
      "Sixty",
      "Seventy",
      "Eighty",
      "Ninety",
    ],
    handle_tens = function (dgt, prevDgt) {
      return 0 == dgt
        ? ""
        : " " + (1 == dgt ? dblDigit[prevDgt] : tensPlace[dgt]);
    },
    handle_utlc = function (dgt, nxtDgt, denom) {
      return (
        (0 != dgt && 1 != nxtDgt ? " " + sglDigit[dgt] : "") +
        (0 != nxtDgt || dgt > 0 ? " " + denom : "")
      );
    };

  var str = "",
    digitIdx = 0,
    digit = 0,
    nxtDigit = 0,
    words = [],
    decimalWords = [],
    priceParts = price.split(".");

  // Handle the integer part
  var integerPart = priceParts[0];

  if (isNaN(parseInt(integerPart))) {
    str = "";
  } else if (parseInt(integerPart) > 0 && integerPart.length <= 12) {
    // Adjusted to handle more digits
    for (digitIdx = integerPart.length - 1; digitIdx >= 0; digitIdx--) {
      switch (
        ((digit = integerPart[digitIdx] - 0),
        (nxtDigit = digitIdx > 0 ? integerPart[digitIdx - 1] - 0 : 0),
        integerPart.length - digitIdx - 1)
      ) {
        case 0:
          words.push(handle_utlc(digit, nxtDigit, ""));
          break;
        case 1:
          words.push(handle_tens(digit, integerPart[digitIdx + 1]));
          break;
        case 2:
          words.push(
            0 != digit
              ? " " +
                  sglDigit[digit] +
                  " Hundred" +
                  (0 != integerPart[digitIdx + 1] &&
                  0 != integerPart[digitIdx + 2]
                    ? " and"
                    : "")
              : "",
          );
          break;
        case 3:
          words.push(handle_utlc(digit, nxtDigit, "Thousand"));
          break;
        case 4:
          words.push(handle_tens(digit, integerPart[digitIdx + 1]));
          break;
        case 5:
          words.push(handle_utlc(digit, nxtDigit, "Lakh"));
          break;
        case 6:
          words.push(handle_tens(digit, integerPart[digitIdx + 1]));
          break;
        case 7:
          words.push(handle_utlc(digit, nxtDigit, "Crore"));
          break;
        case 8:
          words.push(handle_tens(digit, integerPart[digitIdx + 1]));
          break;
        case 9:
          words.push(
            0 != digit
              ? " " +
                  sglDigit[digit] +
                  " Hundred" +
                  (0 != integerPart[digitIdx + 1] ||
                  0 != integerPart[digitIdx + 2]
                    ? " and"
                    : " Crore")
              : "",
          );
          break;
        case 10:
          words.push(handle_utlc(digit, nxtDigit, "Thousand Crore")); // Added Thousand Crore
          break;
        case 11:
          words.push(handle_tens(digit, integerPart[digitIdx + 1]));
          break;
        case 12:
          words.push(handle_utlc(digit, nxtDigit, "Lakh Crore")); // Added Lakh Crore
          break;
      }
    }
    str = words.reverse().join("");
  } else {
    str = "";
  }

  // Handle the fractional part (if present)
  if (priceParts.length > 1) {
    var decimalPart = priceParts[1];
    if (decimalPart.length > 0 && parseInt(decimalPart) > 0) {
      decimalWords.push(" and");
      for (var i = 0; i < decimalPart.length; i++) {
        var decDigit = decimalPart[i] - 0;
        decimalWords.push(" " + sglDigit[decDigit]);
      }
      decimalWords.push(" Paise");
      str += decimalWords.join("");
    }
  }

  return str;
}
