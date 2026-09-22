 @extends('front.website.master')
 @section('title')
     Primary
 @endsection
 @section('content')
     <div class="primary-market">
         <div class="container">
             <div class="row d-flex align-items-center">
                 <div class="col-lg-4 col-sm-12 col-md-12">
                     <h6 class="">Primary Modules</h6>
                     <h1 class="heading mb-4">Primary Startup Shares</h1>
                     <p class="paragraph">Shuru-Up offers investors the opportunity to discover, access & invest in
                         disruptive ventures”. Our
                         software fosters a dynamic investment ecosystem, enabling startups to secure essential funding
                         while offering investors access to early-stage opportunities. </p>
                     <a href="#primary-market-details-section" class="btn btn-light custom-button">Explore More</a>
                 </div>
                 <div class="col-lg-2">
                 </div>

                 <div class="col-lg-6 col-sm-12 col-md-12">
                     <div class="img-container">
                         <img src="{{ asset('website-assets/images/cards-details/primary/cube.svg') }}" alt="primary cube">
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <section class="primary-market-details" id="primary-market-details-section">
         <div class="container">
             <h1 class="text-center heading">Invest in<br>high-growth ventures</h1>
             <div class="row d-flex align-items-center">
                 <div class="col-lg-6 col-sm-12 col-md-12 text-section">
                     <div class="mapped-context">
                         <h3>Get Scrutinized Deals</h3>
                         <p class="paragraph">Shuru-Up offers investors carefully vetted startup opportunities. Our thorough
                             due diligence
                             ensures only high-potential deals, minimizing risks and providing investors with well-analyzed
                             ventures for better decision-making.
                         </p>
                     </div>
                     <div class="mapped-context">
                         <h3>Regular Updates</h3>
                         <p class="paragraph">Investors receive frequent updates on portfolio startups, covering key
                             performance metrics and
                             milestones, ensuring they stay informed and engaged with the progress of their investments in
                             real-time.
                         </p>
                     </div>
                     <div class="mapped-context">
                         <h3>Periodic MIS</h3>
                         <p class="paragraph">Investors receive periodic MIS reports detailing financial and operational
                             performance, allowing
                             them to track startups’ health and make data-driven decisions efficiently. </p>
                     </div>
                     <div class="mapped-context">
                         <h3>Technology-Driven Platform for Making and Tracking Investments</h3>
                         <p class="paragraph">Shuru-Up offers a tech-driven platform that simplifies the entire investment
                             process. Investors
                             can easily explore, invest in, and track startups through a user-friendly interface. The
                             platform provides real-time updates, performance analytics, and portfolio management tools,
                             enabling investors to make informed decisions and seamlessly monitor their investments'
                             progress. </p>
                     </div>
                     <div class="mapped-context">
                         <h3>Direct Captable Investments / AIF</h3>
                         <p class="paragraph">Shuru-Up enables investors to make direct equity investments via cap tables or
                             through
                             Alternative Investment Funds (AIF), offering flexibility in capital allocation, risk
                             management, and portfolio diversification, tailored to individual investment strategies and
                             risk preferences. </p>
                     </div>
                 </div>

                 <div class="col-lg-3 col-sm-12 col-md-12">
                     <div class="line_btw"></div>
                     <div class="line_btw"></div>
                     <div class="line_btw"></div>
                     <div class="line_btw"></div>
                     <div class="line_btw"></div>
                 </div>

                 <div class="col-lg-3 col-sm-12 col-md-12">
                     <div class="img-container">
                         <img src="{{ asset('website-assets/images/cards-details/primary/primary-layers.svg') }}"
                             alt="primary-layers">
                     </div>
                 </div>
             </div>
         </div>
     </section>

     {{-- <section class="common-benefits">
         <div class="container">
             <div class="benefits-details">
                 <h6>Benefits</h6>
                 <h1 class="content-text mb-4 heading">Why Primary Startups Are<br>the Key to Early Success</h1>
                 <p class="para">
                     <strong>First-Mover Advantage:</strong> Early investors in primary startups can
                     capitalize on
                     groundbreaking innovations
                     before they reach the mainstream, gaining a competitive edge.

                     <strong>High Growth Potential:</strong> Startups in their primary stages often experience rapid growth,
                     offering
                     significant upside for early investors as they scale quickly.

                     <strong>Access to Emerging Markets:</strong> Primary startups are often pioneers in new or untapped
                     markets, allowing
                     investors to be part of early market development.

                     <strong>Higher Returns:</strong> Investing early typically offers more favorable valuations, providing
                     the opportunity
                     for exponential returns as the startup matures.

                     <strong>Direct Influence:</strong> Early-stage investors often have more influence over business
                     strategy and growth
                     decisions, aligning with founders to shape the company's trajectory.

                     <strong>Portfolio Diversification:</strong> Investing in primary startups provides portfolio
                     diversification, balancing
                     risk across multiple innovative ventures in emerging industries.

                     <strong>Supporting Innovation:</strong> Primary startups drive innovation, and early investors
                     contribute to the
                     development of new products, services, and solutions that can disrupt entire industries
                 </p>
                 <table>
                     <tbody>
                         <tr>
                             <td><strong>First-Mover Advantage:</strong></td>
                             <td>Early investors in primary startups can capitalize on groundbreaking innovations before
                                 they reach the mainstream, gaining a competitive edge.</td>
                         </tr>
                         <tr>
                             <td><strong>High Growth Potential:</strong></td>
                             <td>Startups in their primary stages often experience rapid growth, offering significant upside
                                 for early investors as they scale quickly.</td>
                         </tr>
                         <tr>
                             <td><strong>Access to Emerging Markets:</strong></td>
                             <td>Primary startups are often pioneers in new or untapped markets, allowing investors to be
                                 part of early market development.</td>
                         </tr>
                         <tr>
                             <td><strong>Higher Returns:</strong></td>
                             <td>Investing early typically offers more favorable valuations, providing the opportunity for
                                 exponential returns as the startup matures.</td>
                         </tr>
                         <tr>
                             <td><strong>Direct Influence:</strong></td>
                             <td>Early-stage investors often have more influence over business strategy and growth
                                 decisions, aligning with founders to shape the company's trajectory.</td>
                         </tr>
                         <tr>
                             <td><strong>Portfolio Diversification:</strong></td>
                             <td>Investing in primary startups provides portfolio diversification, balancing risk across
                                 multiple innovative ventures in emerging industries.</td>
                         </tr>
                         <tr>
                             <td><strong>Supporting Innovation:</strong></td>
                             <td>Primary startups drive innovation, and early investors contribute to the development of new
                                 products, services, and solutions that can disrupt entire industries.</td>
                         </tr>
                     </tbody>
                 </table>
             </div>
         </div>
     </section> --}}

     <div class="primary-market-benefits">
         <div class="container">
             <div class="row d-flex align-items-center">
                 <div class="col-lg-6 col-sm-12 col-md-12">
                     <h6 class="">Benefits</h6>
                     <h1 class="heading mb-4">Why Primary Startups Are the Key to Early Success</h1>
                     <p class="paragraph">Investing with Shuru-Up offers early-stage advantages like first-mover access to
                         innovative startups, high growth potential, and entry into emerging markets. Enjoy favorable
                         valuations with the potential for exponential returns, while directly influencing business strategy
                         alongside founders. Plus, diversify your portfolio across cutting-edge industries and actively
                         support breakthrough products, services, and solutions that drive impactful innovation.</p>
                 </div>
                 <div class="col-lg-1">
                 </div>

                 <div class="col-lg-5 col-sm-12 col-md-12">
                     <div class="img-container">
                         <img src="{{ asset('website-assets/images/cards-details/primary/benefits.svg') }}" alt="benefits">
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
