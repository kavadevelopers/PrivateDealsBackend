@extends('front.website.master')
@section('title')
Team
@endsection
@section('content')
<section class="ezy__team4 dark">
  <div class="container">
    <div class="row justify-content-center mb-4 mb-md-5 mt-4">
      <div class="col-lg-6 col-xl-5 text-center">
        <h2 class="ezy__team4-heading mb-3">Our Team</h2>
        <p class="ezy__team4-sub-heading mb-0">
          Meet our passionate team dedicated to innovation, excellence, and delivering impactful results.
        </p>
      </div>
    </div>

    <!-- Co-Founders Row -->
    <div class="row justify-content-center mb-4">
      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/kedar.jpg') }}" alt="Kedar Dave" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Kedar Dave</h4>
            <p class="small mb-2">Co-Founder / CEO</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/kedar-dave-0b897855/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/viral.jpg') }}" alt="Dr. Viral Shah" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Dr. Viral Shah</h4>
            <p class="small mb-2">Co-Founder</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/viral-shah-79213211a/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/harsh.png') }}" alt="CA Harsh Mehta" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">CA Harsh Mehta</h4>
            <p class="small mb-2">Co-Founder</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/ca-harsh-mehta-6334664a/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/kunal.jpg') }}" alt="Kunal Mehta" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Kunal Mehta</h4>
            <p class="small mb-2">Co-Founder</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/kunal-mehta-6083a325/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/lokesh.jpg') }}" alt="ADV. Lokesh Shah"
            class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">ADV. Lokesh Shah</h4>
            <p class="small mb-2">Co-Founder</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/adv-cs-lokesh-shah-93b5aa87/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Other Team Members -->
    <div class="row justify-content-center">
      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/naishadh.jpeg') }}" alt="Naishadh Dave"
            class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Naishadh Dave</h4>
            <p class="small mb-2">CTO</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/dave-naishadh/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/punit.jpg') }}" alt="Punit Keswani" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Punit Keswani</h4>
            <p class="small mb-2">Investment Associate</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/punitkeswani/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/swati.jpg') }}" alt="Swati Kaushik" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Swati Kaushik</h4>
            <p class="small mb-2">Investment Analyst</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/swati-kaushik-0435741a2/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/satya.jpg') }}" alt="Satya Patel" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Satya Patel</h4>
            <p class="small mb-2">Investment Associate</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/satya-patel-52b090219/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/mehul.jpg') }}" alt="Mehul Kava" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Mehul Kava</h4>
            <p class="small mb-2">Product Manager</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/mehul-kava-6140b0105/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/jigyasa.jpg') }}" alt="CS Jigyasa Sukhwal"
            class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">CS Jigyasa Sukhwal</h4>
            <p class="small mb-2">Legal & Compliance</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/jigyasasukhwal11/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/yash.png') }}" alt="Yash Savaj" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Yash Savaj</h4>
            <p class="small mb-2">Flutter Developer</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/yash-savaj-2979621aa/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-xl-2 mb-4">
        <div class="ezy__team4-item">
          <img src="{{ asset('website-assets/images/team/mohit.jpg') }}" alt="Mohit Janwani" class="img-fluid w-100" />
          <div class="ezy__team4-content px-3 py-3 px-xl-4">
            <h4 class="mb-1">Mohit Janwani</h4>
            <p class="small mb-2">Full-Stack Developer</p>
            <div class="ezy__team4-social-links">
              <a href="https://www.linkedin.com/in/mohit-janwani-40081822a/" target="_blank">
                <span class="fab fa-linkedin-in"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .ezy__team4 {
    /* Bootstrap variables */
    --bs-body-color: #212529;
    --bs-body-bg: rgb(255, 255, 255);

    /* Easy Frontend variables */
    --ezy-theme-color: rgb(13, 110, 253);
    --ezy-theme-color-rgb: 13, 110, 253;
    --ezy-item-bg: #ffffff;
    --ezy-item-shadow: 0px 4px 44px rgba(159, 190, 218, 0.37);

    background: var(--bs-body-bg);
    overflow: hidden;
    padding: 40px 0;
  }

  @media (min-width: 768px) {
    .ezy__team4 {
      padding: 80px 0;
    }
  }

  @media (min-width: 992px) {
    .ezy__team4 {
      padding: 100px 0;
    }
  }

  /* Gray Block Style */
  .gray .ezy__team4,
  .ezy__team4.gray {
    /* Bootstrap variables */
    --bs-body-bg: rgb(246, 246, 246);

    /* Easy Frontend variables */
    --ezy-item-bg: #fff;
    --ezy-item-shadow: 0px 4px 44px rgba(199, 227, 252, 0.17);
  }

  /* Dark Gray Block Style */
  .dark-gray .ezy__team4,
  .ezy__team4.dark-gray {
    /* Bootstrap variables */
    --bs-body-color: #ffffff;
    --bs-body-bg: rgb(30, 39, 53);

    /* Easy Frontend variables */
    --ezy-item-bg: rgb(11, 23, 39);
    --ezy-item-shadow: none;
  }

  /* Dark Block Style */
  .dark .ezy__team4,
  .ezy__team4.dark {
    /* Bootstrap variables */
    --bs-body-color: #ffffff;
    /* --bs-body-bg: rgb(11, 23, 39); */
    --bs-body-bg: #000000;

    /* Easy Frontend variables */
    --ezy-item-bg: rgb(30, 39, 53);
    --ezy-item-shadow: none;
  }

  .ezy__team4-heading {
    font-weight: bold;
    font-size: 28px;
    line-height: 32px;
    color: var(--bs-body-color);
  }

  @media (min-width: 768px) {
    .ezy__team4-heading {
      font-size: 36px;
      line-height: 40px;
    }
  }

  @media (min-width: 992px) {
    .ezy__team4-heading {
      font-size: 45px;
      line-height: 45px;
    }
  }

  .ezy__team4-sub-heading {
    font-size: 14px;
    line-height: 20px;
    color: var(--bs-body-color);
  }

  @media (min-width: 768px) {
    .ezy__team4-sub-heading {
      font-size: 16px;
      line-height: 22px;
    }
  }

  .ezy__team4-item {
    background-color: var(--ezy-item-bg);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--ezy-item-shadow);
    transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .ezy__team4-item:hover {
    transform: translateY(-3px);
  }

  .ezy__team4-item img {
    border-radius: 8px;
    padding: 6px;
    filter: grayscale(100%);
    transition: filter 0.3s ease-in-out;
    aspect-ratio: 1;
    object-fit: cover;
  }

  @media (min-width: 768px) {
    .ezy__team4-item img {
      border-radius: 12px;
      padding: 8px;
    }
  }

  .ezy__team4-item:hover img {
    filter: grayscale(0%);
  }

  .ezy__team4-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 12px 16px !important;
  }

  @media (min-width: 768px) {
    .ezy__team4-content {
      padding: 16px 20px !important;
    }
  }

  .ezy__team4-content * {
    color: var(--bs-body-color);
  }

  .ezy__team4-content h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 4px !important;
  }

  @media (min-width: 768px) {
    .ezy__team4-content h4 {
      font-size: 1.1rem;
      margin-bottom: 6px !important;
    }
  }

  @media (min-width: 992px) {
    .ezy__team4-content h4 {
      font-size: 1.2rem;
      margin-bottom: 8px !important;
    }
  }

  .ezy__team4-content p.small {
    font-size: 0.8rem;
    margin-bottom: 8px !important;
    opacity: 0.8;
  }

  @media (min-width: 768px) {
    .ezy__team4-content p.small {
      font-size: 0.85rem;
      margin-bottom: 10px !important;
    }
  }

  @media (min-width: 992px) {
    .ezy__team4-content p.small {
      font-size: 0.9rem;
      margin-bottom: 12px !important;
    }
  }

  .ezy__team4-social-links {
    margin-top: auto;
  }

  .ezy__team4-social-links a {
    display: inline-block;
    opacity: 0.6;
    transition: opacity 0.25s ease-in-out, transform 0.25s ease-in-out, color 0.25s ease-in-out;
    font-size: 16px;
  }

  @media (min-width: 768px) {
    .ezy__team4-social-links a {
      font-size: 18px;
    }
  }

  .ezy__team4-social-links a:hover {
    opacity: 1;
  }

  /* Mobile-specific improvements */
  @media (max-width: 575px) {
    .ezy__team4 {
      padding: 60px 0;
    }

    .ezy__team4-heading {
      font-size: 24px;
      line-height: 28px;
    }

    .ezy__team4-sub-heading {
      font-size: 13px;
      line-height: 18px;
    }

    .ezy__team4-item {
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .ezy__team4-content h4 {
      font-size: 0.9rem;
    }

    .ezy__team4-content p.small {
      font-size: 0.75rem;
    }
  }

  /* Tablet-specific improvements */
  @media (min-width: 576px) and (max-width: 991px) {
    .ezy__team4-item {
      margin-bottom: 25px;
    }
  }

  /* Remove active class styling since we're not using it */
  .ezy__team4-item.active {
    /* No special styling needed */
  }
</style>
@endsection