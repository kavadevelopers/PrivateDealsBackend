<script>
  $(document).ready(function() {
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        let name = getQueryParam("name");
        let email = getQueryParam("email");
        let mobile = getQueryParam("mobile");
        let firmName = getQueryParam("firm_name");

        if (name) $('input[name="name"]').val(decodeURIComponent(name));
        if (email) $('input[name="email"]').val(decodeURIComponent(email));
        if (mobile) $('input[name="mobile_number"]').val(decodeURIComponent(mobile));
        if (firmName) $('input[name="firm_name"]').val(decodeURIComponent(firmName));
        

        if (name || email || mobile || firmName) {
            $('#inquiryModel').modal('show');
        }
        
        if (window.location.hash === '#request-access') {
            $('#inquiryModel form')[0].reset();
            $('#inquiryModel').modal('show');
        }
        $('ul.navbar-nav li.dropdown').hover(function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(50);
        }, function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
        });

        $('#spinningLoader').fadeOut('200');
        $('.request-access-card').on('click', function(event) {
            event.preventDefault();
            $('#inquiryModel form')[0].reset();
            $('#inquiryModel').modal('show');
        });
        $('.betaTestingBtn').on('click', function(event) {
            event.preventDefault();
            $('#betaTestingModel form')[0].reset();
            $('#betaTestingModel').modal('show');
        });

        $('#inquiryModel form').on('submit', function(event) {
            event.preventDefault();
            sendVerificationCode();
        });

        $('#resendInquiryOtp').on('click', function(event) {
            event.preventDefault();
            sendVerificationCode();
        });

        $('#inquiryVerifyModel form').on('submit', function(event) {
            event.preventDefault();
            showSpinningLoader(true);
            $.ajax({
                url: "{{ route('front.inquiry.verifyCode') }}",
                type: 'POST',
                data: $('#inquiryVerifyModel form').serialize(),
                dataType: 'json',
                success: function(data) {
                    showSpinningLoader(false);
                    if (data.status) {
                        successAlert(data.message);
                        $('#inquiryModel').modal('hide');
                        $('#inquiryVerifyModel').modal('hide');
                    } else {
                        errorAlert(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorAlert('Please try again later');
                }
            });
        });

        $('#betaTestingModel form').on('submit', function(event) {
            event.preventDefault();
            showSpinningLoader(true);
            $.ajax({
                url: "{{ route('front.betatesting') }}",
                type: 'POST',
                data: $('#betaTestingModel form').serialize(),
                dataType: 'json',
                success: function(data) {
                    showSpinningLoader(false);
                    if (data.status) {
                        successAlert(data.message);
                        $('#betaTestingModel').modal('hide');
                    } else {
                        errorAlert(data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorAlert('Please try again later');
                }
            });
        });
    });

    function sendVerificationCode() {
        showSpinningLoader(true);
        $.ajax({
            url: "{{ route('front.inquiry.sendCode') }}",
            type: 'POST',
            data: $('#inquiryModel form').serialize(),
            dataType: 'json',
            success: function(data) {
                showSpinningLoader(false);
                $('#inquiryModel').modal('show');
                if (data.status) {
                    successAlert(data.message);
                    $('#inquiryModel').modal('hide');
                    $('#inquiryVerifyModel').modal('hide');

                    setTimeout(function() {
                    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

                    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                        window.location.href = "https://apps.apple.com/us/app/shuru-up-business/id6737124969";
                    } 
                    else if (/android/i.test(userAgent)) {
                        window.location.href = "https://play.google.com/store/apps/details?id=com.shuruup.distributor";
                    }
                    else if (/macintosh|mac os x/i.test(userAgent)) {
                        window.location.href = "https://apps.apple.com/us/app/shuru-up-business/id6737124969";
                    }
                    // else if (/windows|win32/i.test(userAgent)) {
                    //     window.location.href = "https://desktop.example.com";
                    // }
                    else {
                        window.location.href = "https://shuruup.com";
                    }
                }, 1000);
                } else {
                    showSpinningLoader(false);
                    errorAlert(data.message);
                }
                // if (data.status) {
                //     successAlert(data.message);
                //     $('#inquiryVerifyModel form')[0].reset();
                //     $('#inquiryVerifyModel').modal('show');
                //     $('#inquiryVerifyModel input[name=name]').val($('#inquiryModel input[name=name]')
                //         .val());
                //     $('#inquiryVerifyModel input[name=mobile_number]').val($(
                //             '#inquiryModel input[name=mobile_number]')
                //         .val());
                //     $('#inquiryVerifyModel input[name=email]').val($(
                //             '#inquiryModel input[name=email]')
                //         .val());
                //     $('#inquiryModel').modal('hide');
                // } else {
                //     errorAlert(data.message);
                // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorAlert('Please try again later');
            }
        });
    }

    //home video starts
    //home video ends

    document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".terminal-functions-custom-button");

  // Function to check if device is mobile
  function isMobile() {
    return window.innerWidth <= 768;
  }

  buttons.forEach((button) => {
    const arrowBtn = button.querySelector(".arrow-btn");
    const arrowIcon = arrowBtn.querySelector("i");

    function resetButton() {
      button.classList.remove("active");
      // Force icon change - more reliable method
      arrowIcon.classList.remove("fa-times");
      arrowIcon.classList.add("fa-arrow-right");
      button.style.transform = "none";
      arrowBtn.style.transform = "translateX(0)";
    }

    function activateButton() {
      // Close other buttons first
      buttons.forEach(otherButton => {
        if (otherButton !== button) {
          otherButton.classList.remove("active");
          const otherArrowIcon = otherButton.querySelector(".arrow-btn i");
          const otherArrowBtn = otherButton.querySelector(".arrow-btn");
          otherArrowIcon.classList.remove("fa-times");
          otherArrowIcon.classList.add("fa-arrow-right");
          otherArrowBtn.style.transform = "translateX(0)";
        }
      });

      // Activate current button
      arrowIcon.classList.remove("fa-arrow-right");
      arrowIcon.classList.add("fa-times");
      button.classList.add("active");
      
      if (isMobile()) {
        arrowBtn.style.transform = "translateX(200px)";
      } else {
        arrowBtn.style.transform = "translateX(240px)";
      }
    }

    // Desktop hover events
    if (!isMobile()) {
      button.addEventListener("mouseenter", function () {
        activateButton();
      });

      button.addEventListener("mouseleave", function () {
        resetButton();
      });
    }

    // Arrow button click - works for both mobile and desktop
    arrowBtn.addEventListener("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      
      console.log("Arrow clicked, button active:", button.classList.contains("active"));
      
      if (button.classList.contains("active")) {
        console.log("Closing button");
        resetButton();
      } else {
        console.log("Opening button");
        activateButton();
      }
    });

    // Don't prevent clicks on the whole button for mobile
    // Let the arrow handle it
  });

  // Desktop mouse move effect (only for non-mobile)
  if (!isMobile()) {
    document.addEventListener("mousemove", function (e) {
      const mouseX = e.clientX;
      const mouseY = e.clientY;
      const centerX = window.innerWidth / 2;
      const centerY = window.innerHeight / 2;
      const offsetX = (mouseX - centerX) / centerX;
      const offsetY = (mouseY - centerY) / centerY;

      buttons.forEach((button) => {
        if (!button.classList.contains("active")) {
          const rect = button.getBoundingClientRect();
          const distX = mouseX - (rect.left + rect.width / 2);
          const distY = mouseY - (rect.top + rect.height / 2);
          const distance = Math.sqrt(distX * distX + distY * distY);
          const maxDistance =
            Math.sqrt(window.innerWidth ** 2 + window.innerHeight ** 2) / 4;
          const intensity = 1 - Math.min(distance / maxDistance, 1);
          const tiltX = -offsetY * 10 * intensity;
          const tiltY = offsetX * 10 * intensity;

          button.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateX(${
            offsetX * 5
          }px) translateY(${offsetY * 5}px)`;
        } else {
          button.style.transform = "none";
        }
      });
    });
  }

  // Click outside to close (only for mobile)
  document.addEventListener("click", function (event) {
    if (isMobile()) {
      const clickedButton = event.target.closest(".terminal-functions-custom-button");
      if (!clickedButton) {
        buttons.forEach((button) => {
          resetButton();
        });
      }
    }
  });

  // Handle window resize
  window.addEventListener("resize", function() {
    buttons.forEach((button) => {
      resetButton();
    });
  });
});

// aboutus mission vision starts

// aboutus mission vision starts
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('visionMissionVideo');
    const section = document.querySelector('.vision-mission-section');
    const missionContents = document.querySelectorAll('.mission-content');
    let hasTriggered = false; // Flag to ensure animations trigger only once
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !hasTriggered) {
                // Section is visible - start video and animations
                
                // Play video
                video.play();
                
                // Trigger text animations by adding animate class
                missionContents.forEach(content => {
                    content.classList.add('animate');
                });
                
                hasTriggered = true;
                
                // Stop observing after first trigger
                observer.unobserve(section);
            }
        });
    }, {
        threshold: 0.3 // Trigger when 30% of section is visible
    });
    
    observer.observe(section);
});
// aboutus mission vision ends



// aboutus mission vision ends


document.addEventListener('DOMContentLoaded', function () {
const getObserverOptions = () => {
const isMobile = window.innerWidth <= 768; return { threshold: isMobile ? 0.2 : 0.1, rootMargin: isMobile
  ? '0px 0px -100px 0px' : '0px 0px -200px 0px' }; }; const observer=new IntersectionObserver((entries)=> {
  entries.forEach(entry => {
  if (entry.isIntersecting) {
  // Handle slide animations (new functionality)
  const slideElements = entry.target.querySelectorAll('.slide-from-left, .slide-from-right,.slide-from-bottom');
  if (slideElements.length > 0) {
  slideElements.forEach((element, index) => {
  setTimeout(() => {
  element.classList.add('animate-in');

  // Then animate children with stagger
  const childElements = element.querySelectorAll('.animate-child');
  childElements.forEach((child, childIndex) => {
  setTimeout(() => {
  child.classList.add('animate-in');
  }, (childIndex + 1) * 300);
  });
  }, index * 200); // Stagger the main slide animations
  });
  } else {
  // Handle existing scroll-animate functionality
  entry.target.classList.add('animate-in');

  const childElements = entry.target.querySelectorAll('.animate-child');
  childElements.forEach((child, index) => {
  setTimeout(() => {
  child.classList.add('animate-in');
  }, index * 200);
  });
  }
  }
  });
  }, getObserverOptions());

  const scrollElements = document.querySelectorAll('.scroll-animate');
  scrollElements.forEach(el => {
  const hasSlideElements = el.querySelector('.slide-from-left, .slide-from-right, .slide-from-bottom');
  if (!hasSlideElements) {
  const children = el.querySelectorAll(':scope > *');
  children.forEach(child => child.classList.add('animate-child'));
  }

  observer.observe(el);
  });
  });

  const style = document.createElement('style');
  style.textContent = `
  .features-section .feature-card {
  animation-play-state: paused;
  }

  .features-section.animate .feature-card {
  animation-play-state: running;
  }
  `;
  document.head.appendChild(style);

  const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
  if (entry.isIntersecting) {
  entry.target.classList.add('animate');
  observer.unobserve(entry.target);
  }
  });
  }, {
  threshold: 0.3
  });


  const featuresSection = document.querySelector('.features-section');
  if (featuresSection) {
  observer.observe(featuresSection);
  }

  document.addEventListener('DOMContentLoaded', function() {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
  const question = item.querySelector('.faq-question');
  const toggle = item.querySelector('.faq-toggle i');
  const answer = item.querySelector('.faq-answer');

  question.addEventListener('click', function() {
  const isActive = item.classList.contains('active');


  faqItems.forEach(faq => {
  if (faq !== item) {
  const faqAnswer = faq.querySelector('.faq-answer');
  const faqToggle = faq.querySelector('.faq-toggle i');

  faq.classList.remove('active');
  faqToggle.className = 'fas fa-plus';


  faqAnswer.style.maxHeight = faqAnswer.scrollHeight + 'px';
  setTimeout(() => {
  faqAnswer.style.maxHeight = '0px';
  }, 10);
  }
  });


  if (!isActive) {

  item.classList.add('active');
  toggle.className = 'fas fa-chevron-up';

  answer.style.maxHeight = '0px';
  answer.style.display = 'block';
  setTimeout(() => {
  answer.style.maxHeight = answer.scrollHeight + 'px';
  }, 10);
  } else {

  toggle.className = 'fas fa-plus';
  answer.style.maxHeight = answer.scrollHeight + 'px';
  setTimeout(() => {
  answer.style.maxHeight = '0px';
  setTimeout(() => {
  item.classList.remove('active');
  answer.style.display = 'none';
  }, 300);
  }, 10);
  }
  });
  });
  });


  // // mission-vision-goals
  // document.addEventListener('DOMContentLoaded', function () {
  // // Observer for Mission & Vision (e.g., trigger when 20% visible)
  // const missionObserver = new IntersectionObserver((entries, observer) => {
  // entries.forEach(entry => {
  // if (entry.isIntersecting) {
  // entry.target.classList.add('animate');
  // observer.unobserve(entry.target);
  // }
  // });
  // }, {
  // threshold: 0.2 // ✅ Mission/Vision threshold
  // });

  // // Observer for Goals section (e.g., trigger when 50% visible)
  // const goalsObserver = new IntersectionObserver((entries, observer) => {
  // entries.forEach(entry => {
  // if (entry.isIntersecting) {
  // entry.target.classList.add('animate');
  // observer.unobserve(entry.target);
  // }
  // });
  // }, {
  // threshold: 0.1 // ✅ Goals section threshold
  // });

  // // Apply observers
  // document.querySelectorAll('.mission-section .mission-content').forEach(el => {
  // missionObserver.observe(el);
  // });

  // document.querySelectorAll('.goals-section .mission-content').forEach(el => {
  // goalsObserver.observe(el);
  // });
  // });


  //journey
  // Add this JavaScript code
  document.addEventListener('DOMContentLoaded', function() {
  // Journey section animation
  const journeyContents = document.querySelectorAll('.journey-content');

  const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
  if (entry.isIntersecting) {
  entry.target.classList.add('animate');
  }
  });
  }, observerOptions);

  journeyContents.forEach(content => {
  observer.observe(content);
  });
  });
// Start News Slider - Fixed Speed Issue
document.addEventListener('DOMContentLoaded', function() {
    const startNewsSection = document.querySelector('.start-news-slider');
    if (!startNewsSection) return;
    
    const slider = startNewsSection.querySelector('#startNewsSlider');
    const paginationContainer = startNewsSection.querySelector('#sliderPagination');
    
    if (!slider) return;
    
    const cards = slider.querySelectorAll('.news-card');
    let currentIndex = 0;
    let cardsPerView = 4;
    let totalSlides = Math.ceil(cards.length / cardsPerView);
    
    function updateCardsPerView() {
        const screenWidth = window.innerWidth;
        
        if (screenWidth <= 480) {
            cardsPerView = 1;
        } else if (screenWidth <= 768) {
            cardsPerView = 1;
        } else if (screenWidth <= 1200) {
            cardsPerView = 2;
        } else {
            cardsPerView = 4;
        }
        
        totalSlides = Math.max(1, Math.ceil(cards.length / cardsPerView));
        
        // Reset currentIndex if it's out of bounds
        if (currentIndex >= totalSlides) {
            currentIndex = totalSlides - 1;
        }
        
        createPagination();
        updateSlider();
    }
    
    function createPagination() {
        if (!paginationContainer) return;
        paginationContainer.innerHTML = '';
        
        // Only create pagination if there are multiple slides
        if (totalSlides > 1) {
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.className = 'pagination-dot';
                dot.addEventListener('click', () => goToSlide(i));
                paginationContainer.appendChild(dot);
            }
        }
        updatePagination();
    }
    
    function updateSlider() {
        if (cardsPerView >= cards.length) {
            // If we can show all cards, don't translate
            slider.style.transform = 'translateX(0%)';
        } else {
            // Calculate based on actual card movement, not percentage
            const translateX = -(currentIndex * (100 / cardsPerView));
            slider.style.transform = `translateX(${translateX}%)`;
        }
        updatePagination();
    }
    
    function updatePagination() {
        if (!paginationContainer) return;
        const dots = paginationContainer.querySelectorAll('.pagination-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }
    
    function goToSlide(index) {
        if (index >= 0 && index < totalSlides) {
            currentIndex = index;
            updateSlider();
        }
    }
    
    function nextSlide() {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // Loop back to start
        }
        updateSlider();
    }
    
    function prevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = totalSlides - 1; // Loop to end
        }
        updateSlider();
    }
    
    let autoPlayInterval;
    
    function startAutoPlay() {
        // Only start autoplay if there are multiple slides
        if (totalSlides > 1) {
            autoPlayInterval = setInterval(() => {
                nextSlide();
            }, 5000); 
        }
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
            autoPlayInterval = null;
        }
    }
    
    // Touch/Swipe support with improved logic
    let startX = 0;
    let endX = 0;
    let isDragging = false;
    
    slider.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        endX = startX;
        isDragging = true;
        stopAutoPlay();
    });
    
    slider.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        endX = e.touches[0].clientX;
        e.preventDefault(); // Prevent scrolling
    });
    
    slider.addEventListener('touchend', () => {
        if (!isDragging) return;
        
        const threshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold && totalSlides > 1) {
            if (diff > 0) {
                // Swipe left - next slide
                nextSlide();
            } else {
                // Swipe right - previous slide
                prevSlide();
            }
        }
        
        isDragging = false;
        setTimeout(() => {
            startAutoPlay();
        }, 100);
    });
    
    // Mouse events for desktop
    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', () => {
        if (!isDragging) {
            startAutoPlay();
        }
    });
    
    // Initialize
    updateCardsPerView();
    startAutoPlay(); 
    
    // Handle resize with proper debouncing
    let resizeTimeout;
    window.addEventListener('resize', () => {
        stopAutoPlay();
        
        if (resizeTimeout) {
            clearTimeout(resizeTimeout);
        }
        
        resizeTimeout = setTimeout(() => {
            updateCardsPerView();
            if (!isDragging) {
                startAutoPlay();
            }
        }, 150);
    });
});


</script>