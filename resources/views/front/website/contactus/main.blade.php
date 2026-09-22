 @extends('front.website.master')
 <div class="container">
     <div class="contactus">
         <div class="d-flex justify-content-center align-items-center">
             <div class="contact-container">
                 <div class="contact-content">
                     <h1>Get in touch with us</h1>
                     <p>Reduce costs, grow revenue, and run your business more efficiently on a fully integrated
                         platform. Use
                         Stripe to handle all of your payment-related needs, manage revenue operations, and launch (or
                         invent)
                         new business models.</p>
                     <a href="{{ route('front.contact-us.details') }}" class="contact-button">Contact Us</a>
                 </div>
             </div>
         </div>
     </div>
     <div class="contact-page d-flex align-items-center">
         <div class="row">
             <div class="col-6 col-md-6 text-white p-5 left-section">
                 <h6>Get in touch</h6>
                 <h2>Seamless communication, Global Impact.</h2>
                 <p class="small-text">Reduce costs, grow revenue, and run your business more efficiently on a
                     fully integrated platform. Use Stripe to handle all of your payments-related needs, manage revenue
                     operations, and launch (or invent) new business models.</p>
                 <hr class="divider">

                 <div class="contact-info d-flex justify-content-between mt-5 mb-4">
                     <div class="text-center">
                         <i class="fas fa-envelope fa-1x mb-2 p-3 bg-dark rounded-circle"></i>
                         <p class="m-0">
                             <span class="d-block live-support">Live Support</span>
                             <span class="support-email">support@example.com</span>
                         </p>
                     </div>
                     <div class="text-center">
                         <i class="fas fa-phone fa-1x mb-2 p-3 bg-dark rounded-circle"></i>
                         <p class="m-0"></p>
                         <span class="d-block live-support">Contact Info</span>
                         <span class="support-email">+91 1234567890</span>
                         </p>
                     </div>
                     <div class="text-center">
                         <i class="fas fa-map-marker-alt fa-1x mb-2 p-3 bg-dark rounded-circle"></i>
                         <p class="m-0">
                             <span class="d-block live-support">Our Address</span>
                             <span class="support-email">Street Name, City</span>
                         </p>
                     </div>
                     <div class="text-center">
                         <i class="fas fa-clock fa-1x mb-2 p-3 bg-dark rounded-circle"></i>
                         <p class="m-0">
                             <span class="d-block live-support">Work Day</span>
                             <span class="support-email">Mon-Fri 9:00am - 8:00pm</span>
                         </p>
                     </div>
                 </div>
                 <hr class="divider">

                 <div class="social-media-section mt-4">
                     <h6>Follow our social media</h6>
                     <div class="social-media d-flex mt-4">
                         <a href="#" class="icon-box text-white d-flex align-items-center justify-content-center">
                             <i class="fab fa-facebook fa-2x"></i>
                         </a>
                         <a href="#" class="icon-box text-white d-flex align-items-center justify-content-center">
                             <i class="fab fa-instagram fa-2x"></i>
                         </a>
                         <a href="#" class="icon-box text-white d-flex align-items-center justify-content-center">
                             <i class="fab fa-twitter fa-2x"></i>
                         </a>
                         <a href="#" class="icon-box text-white d-flex align-items-center justify-content-center">
                             <i class="fab fa-linkedin fa-2x"></i>
                         </a>
                         <a href="#" class="icon-box text-white d-flex align-items-center justify-content-center">
                             <i class="fab fa-youtube fa-2x"></i>
                         </a>
                     </div>
                 </div>
             </div>
             <div class="col-6 col-md-6 p-5 form-section">
                 <h4 class="text-white mb-4">Send us a message</h4>
                 <p class="mb-4">Reduce costs, grow revenue, and run your business more efficiently on a fully
                     integrated platform. Use Stripe to handle all your payments.</p>
                 <form>
                     <div class="row">
                         <div class="form-group col-md-6">
                             <label for="name" class="text-white">Name</label>
                             <input type="text" class="form-control" id="name" placeholder="Name">
                         </div>
                         <div class="form-group col-md-6">
                             <label for="company" class="text-white">Company</label>
                             <input type="text" class="form-control" id="company" placeholder="Company">
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-md-6">
                             <label for="phone" class="text-white">Phone</label>
                             <input type="text" class="form-control" id="phone" placeholder="Phone">
                         </div>
                         <div class="form-group col-md-6">
                             <label for="email" class="text-white">Email</label>
                             <input type="email" class="form-control" id="email" placeholder="Email">
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="subject" class="text-white">Subject</label>
                         <input type="text" class="form-control" id="subject" placeholder="Subject">
                     </div>
                     <div class="form-group">
                         <label for="message" class="text-white">Message</label>
                         <textarea class="form-control" id="message" rows="4" placeholder="Message"></textarea>
                     </div>
                     <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                 </form>
             </div>
         </div>
     </div>
 </div>
