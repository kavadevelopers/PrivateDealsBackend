 @extends('front.website.master')
 @section('title')
     Secondary
 @endsection
 @section('content')
     <div class="secondary-market">
         <div class="container">
             <div class="row d-flex align-items-center">
                 <div class="col-lg-5 col-sm-12 col-md-12">
                     <h6 class="">Secondary Shares</h6>
                     <h1 class="heading">What are Secondary Shares?</h1>
                     <p class="paragraph">Unlike the primary shares, which are the securities created and sold for the first
                         time (such as
                         during an Initial Public Offering or IPO), the secondary shares are the securities of the existing
                         investors. This secondary platform is essential for providing liquidity, enabling investors to
                         access funds and reallocate their investments as needed.</p>
                     <a href="#secondary-market-section" class="btn btn-light custom-button">Explore More</a>
                 </div>
                 <div class="col-lg-1">
                 </div>

                 <div class="col-lg-6 col-md-12">
                     <div class="img-container">
                         <img src="{{ asset('website-assets/images/cards-details/secondary/trade.svg') }}" alt="trade">
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <section class="secondary-market-details" id="secondary-market-section">
         <div class="container">
             <div class="row d-flex align-items-center">
                 <div class="col-lg-5 col-sm-12 col-md-12 mb-4">
                     <div class="img-container p-5">
                         <img src="{{ asset('website-assets/images/cards-details/secondary/transaction.svg') }}"
                             alt="transaction">
                     </div>
                 </div>
                 <div class="col-lg-1">
                 </div>
                 <div class="col-lg-5 col-sm-12 col-md-12">
                     {{-- <h6 class="">Secondary Shares</h6> --}}
                     <h1 class="heading">Explore New Horizons in Private Investments</h1>
                     <p class="paragraph">Step into the secondary platform for start-ups, where unique opportunities await.
                         This dynamic
                         environment enables investors to acquire and sell interests in promising companies, enhancing
                         portfolio liquidity and opening doors to emerging ventures.</p>
                 </div>
                 <div class="col-lg-1">
                 </div>
             </div>
         </div>
     </section>

     <div class="secondary-market-fingertip">
         <div class="container">
             <div class="row d-flex align-items-center">
                 <div class="col-lg-5 col-sm-12 col-md-12">
                     {{-- <h6 class="">Secondary Shares</h6> --}}
                     <h1 class="heading">Effortless Investing at Your Fingertips</h1>
                     <p class="paragraph">With our intuitive digital platform, investing in private companies is streamlined
                         and hassle-free. Experience quick, paperless transactions with all your documents securely stored
                         in the cloud. Manage your investments conveniently, anytime and anywhere.</p>
                 </div>
                 <div class="col-lg-1">
                 </div>

                 <div class="col-lg-6 col-md-12">
                     <div class="img-container">
                         <img src="{{ asset('website-assets/images/cards-details/secondary/fingertip.svg') }}"
                             alt="trade">
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <section class="secondary-market-empowerment">
         <div class="container">
             <div class="row d-flex align-items-center">
                 <div class="col-lg-5 col-sm-12 col-md-12 mb-4">
                     <div class="img-container p-5">
                         <img src="{{ asset('website-assets/images/cards-details/secondary/empowerment.svg') }}"
                             alt="transaction">
                     </div>
                 </div>
                 <div class="col-lg-1">
                 </div>
                 <div class="col-lg-6 col-sm-12 col-md-12">
                     {{-- <h6 class="">Secondary Shares</h6> --}}
                     <h1 class="heading">Empower Your Portfolio with Strategic Flexibility</h1>
                     <p class="paragraph">Unlock the potential of liquidity in your investments by diversifying into private
                         companies. Our ecosystem promotes healthy investment flows, providing you with the flexibility and
                         control you need, all while ensuring a smooth digital transaction process.</p>
                 </div>
             </div>
         </div>
     </section>
     {{-- <section class="common-benefits">
         <div class="container">
             <div class="benefits-details">
                 <h6>Benefits</h6>
                 <h1 class="content-text mb-4 heading">Effortless Investing at<br>Your Fingertips</h1>
                 <p class="paragraph">
                     With our intuitive digital platform, investing in private companies is streamlined and hassle-free.
                     Experience quick, paperless transactions with all your documents securely stored in the cloud. Manage
                     your
                     investments conveniently, anytime and anywhere.
                 </p>
             </div>
         </div>
     </section>

     <section class="common-benefits">
         <h6>Benefits</h6>
         <div class="container">
             <div class="benefits-details">
                 <h1 class="content-text mb-4 heading">Empower Your Portfolio <br>with Strategic Flexibility</h1>
                 <p class="paragraph">
                     Unlock the potential of liquidity in your investments by diversifying into private companies. Our
                     ecosystem
                     promotes healthy investment flows, providing you with the flexibility and control you need, all while
                     ensuring a smooth digital transaction process.
                 </p>
             </div>
         </div>
     </section> --}}
 @endsection
