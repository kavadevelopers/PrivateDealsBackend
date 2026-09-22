const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    console.log(entry);
    if (entry.isIntersecting) {
      entry.target.classList.add("show");
    } else {
      entry.target.classList.remove("show");
    }
  });
});

const cardContainer = document.querySelector(".card-container");
if (cardContainer) {
  const cards = cardContainer.querySelectorAll(".card");

  // Function to set width based on device size
  function setCardContainerWidth() {
    if (window.innerWidth <= 991) {
      cardContainer.style.width = "100%";
    } else {
      cardContainer.style.width = ""; // Reset to default width
    }
  }

  // Initial width setting
  setCardContainerWidth();

  // Add event listener for window resize
  window.addEventListener("resize", setCardContainerWidth);

  cards.forEach((card, index) => {
    if (index !== 0) {
      card.classList.remove("open"); // Collapse the rest
      card.querySelector(".short-description").classList.remove("hidden"); // Show short description
      card.querySelector(".long-description").classList.add("hidden"); // Hide long description
    } else {
      card.classList.add("open"); // Open the first card
      card.querySelector(".short-description").classList.add("hidden"); // Hide short description
      card.querySelector(".long-description").classList.remove("hidden"); // Show long description
    }
  });

  cardContainer.addEventListener("mouseover", function (event) {
    const targetCard = event.target.closest(".card");
    if (targetCard && !targetCard.classList.contains("open")) {
      // Collapse all cards except the hovered one
      cards.forEach((card) => {
        card.classList.remove("open");
        card.querySelector(".short-description").classList.remove("hidden"); // Show short description
        card.querySelector(".long-description").classList.add("hidden"); // Hide long description
      });
      targetCard.classList.add("open");
      targetCard.querySelector(".short-description").classList.add("hidden"); // Hide short description
      targetCard.querySelector(".long-description").classList.remove("hidden"); // Show long description
    }
  });

  cardContainer.addEventListener("mouseout", function (event) {
    const targetCard = event.target.closest(".card");
    if (targetCard) {
      // Restore the height of cards when mouse leaves
      cards.forEach((card, i) => {
        if (i !== 0) {
          card.classList.remove("open");
          card.querySelector(".short-description").classList.remove("hidden"); // Show short description
          card.querySelector(".long-description").classList.add("hidden"); // Hide long description
        } else {
          card.classList.add("open"); // Keep the first card open
          card.querySelector(".short-description").classList.add("hidden"); // Hide short description
          card.querySelector(".long-description").classList.remove("hidden"); // Show long description
        }
      });
    }
  });
}

//
//
//
//
function showSpinningLoader(state = true) {
  if (state) {
    console.log("Loader is starting...");
    $("#spinningLoader").show();
  } else {
    console.log("Loader is stopping...");
    $("#spinningLoader").hide();
  }
}

const statisticsLink = document.querySelector('a[href="#statistics-section"]');
const statisticsSection = document.querySelector("#statistics-section");

if (statisticsLink && statisticsSection) {
  statisticsLink.addEventListener("click", function (e) {
    e.preventDefault();
    const offset = 100;

    const sectionPosition =
      statisticsSection.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = sectionPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
  });
}
//more about us
const moreAboutUsLink = document.querySelector(
  'a[href="#about-us-details-section"]'
);
const aboutUsDetailsSection = document.querySelector(
  "#about-us-details-section"
);

if (moreAboutUsLink && aboutUsDetailsSection) {
  moreAboutUsLink.addEventListener("click", function (e) {
    e.preventDefault();
    const offset = 100;

    const sectionPosition =
      aboutUsDetailsSection.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = sectionPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
  });
}
//about portfolio
const aboutPortfolioLink = document.querySelector(
  'a[href="#about-portfolio-section"]'
);
const aboutPortfolioSection = document.querySelector(
  "#about-portfolio-section"
);

if (aboutPortfolioLink && aboutPortfolioSection) {
  aboutPortfolioLink.addEventListener("click", function (e) {
    e.preventDefault();
    const offset = 100;

    const sectionPosition =
      aboutPortfolioSection.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = sectionPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
  });
}

//primary
const exploreMoreLink = document.querySelector(
  'a[href="#primary-market-details-section"]'
);
const primaryMarketSection = document.querySelector(
  "#primary-market-details-section"
);

if (exploreMoreLink && primaryMarketSection) {
  exploreMoreLink.addEventListener("click", function (e) {
    e.preventDefault();
    const offset = 100;

    const sectionPosition =
      primaryMarketSection.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = sectionPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
  });
}
//secondary
const exploreMoreSecondaryLink = document.querySelector(
  'a[href="#secondary-market-section"]'
);
const secondaryMarketSection = document.querySelector(
  "#secondary-market-section"
);

if (exploreMoreSecondaryLink && secondaryMarketSection) {
  exploreMoreSecondaryLink.addEventListener("click", function (e) {
    e.preventDefault();
    const offset = 100;

    const sectionPosition =
      secondaryMarketSection.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = sectionPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
  });
}
//pre-ipo
const exploreMorePreIpoLink = document.querySelector(
  'a[href="#pre-ipo-section"]'
);
const preIpoSection = document.querySelector("#pre-ipo-section");

if (exploreMorePreIpoLink && preIpoSection) {
  exploreMorePreIpoLink.addEventListener("click", function (e) {
    e.preventDefault();
    const offset = 100;

    const sectionPosition =
      preIpoSection.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = sectionPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: "smooth",
    });
  });
}

// shimmer
const lazyImages = document.querySelectorAll(".lazy");
if (lazyImages.length > 0) {
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
}

function isElementInViewport(el) {
  const rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
  );
}

// Scroll event listener
window.addEventListener("scroll", function () {
  const sections = document.querySelectorAll(".investors-dashboard");

  sections.forEach((section) => {
    const mobileImage = section.querySelector(".mobile-image");

    if (isElementInViewport(section)) {
      mobileImage.classList.add("slide-in");
    }
  });
});
document.querySelectorAll(".custom-button").forEach((button) => {
  button.addEventListener("mouseover", function (e) {
    const existingRipple = this.querySelector(".ripple");
    if (existingRipple) {
      existingRipple.remove();
    }

    const ripple = document.createElement("span");
    ripple.classList.add("ripple");
    this.appendChild(ripple);

    const rect = this.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    // Set ripple position
    ripple.style.left = `${x}px`;
    ripple.style.top = `${y}px`;
  });

  // Clean up ripple when hover ends
  button.addEventListener("mouseleave", function () {
    const ripple = this.querySelector(".ripple");
    if (ripple) {
      ripple.remove();
    }
  });
});

// document.addEventListener("DOMContentLoaded", () => {
//   const blob = document.querySelector(".blob-1");
//   const body = document.body;

//   // Debounce function to improve performance
//   function debounce(func, wait) {
//     let timeout;
//     return function executedFunction(...args) {
//       const later = () => {
//         clearTimeout(timeout);
//         func(...args);
//       };
//       clearTimeout(timeout);
//       timeout = setTimeout(later, wait);
//     };
//   }

//   // Function to update blob position
//   function updateBlobPosition(e) {
//     // Ensure blob follows cursor across entire page, including during scroll
//     let x = e.clientX - 125; // Center the blob on cursor
//     let y = e.clientY - 125 + window.scrollY; // Account for scroll position

//     // Constrain to window bounds
//     x = Math.max(-100, Math.min(window.innerWidth - 150, x));
//     y = Math.max(0, Math.min(window.innerHeight - 150 + window.scrollY, y));

//     // Apply the transform
//     blob.style.transform = `translate(${x}px, ${y}px)`;

//     // Ensure blob is visible and following
//     blob.classList.add("following");
//   }

//   // Debounced version of update function
//   const debouncedUpdateBlobPosition = debounce(updateBlobPosition, 10);

//   // Add listeners to entire document
//   document.addEventListener("mousemove", debouncedUpdateBlobPosition);
//   document.addEventListener("scroll", debouncedUpdateBlobPosition);

//   // Optional: Reset blob on mouse enter to ensure it starts moving
//   document.addEventListener("mouseenter", () => {
//     blob.classList.add("following");
//   });

//   // Optional: Handle cases where mouse leaves document
//   document.addEventListener("mouseleave", () => {
//     blob.classList.remove("following");
//   });
// });
//  window.onload = function () {
//             document.getElementById('contactPage').classList.add('show');
//         };
// window.addEventListener("DOMContentLoaded", (event) => {
//   const options = {
//     root: null,
//     threshold: 0.5,
//   };

//   const observer = new IntersectionObserver((entries, observer) => {
//     entries.forEach((entry) => {
//       if (entry.isIntersecting) {
//         setTimeout(() => {
//           document.querySelector(".laptop-img").classList.add("show");
//         }, 500);

//         setTimeout(() => {
//           document.querySelector(".phone-img").classList.add("show");
//         }, 1000);
//         observer.disconnect();
//       }
//     });
//   }, options);

//   const target = document.querySelector(".terminal");
//   if (target) {
//     observer.observe(target);
//   }
// });

//
//
//
//
