<?php

return array (
  'site_url' => 'https://privatedeals.in',
  'partner_login_url' => 'https://partner.privatedeals.in/sign-in',
  'og_image' => 'https://privatedeals.in/marketing/images/favicons/web-app-manifest-512x512.png',
  'nav' => 
  array (
    'primary' => 
    array (
      0 => 
      array (
        'label' => 'Home',
        'path' => '/',
      ),
      1 => 
      array (
        'label' => 'About Us',
        'path' => '/about',
      ),
      2 => 
      array (
        'label' => 'Opportunities',
        'path' => '/opportunities',
        'children' => 
        array (
          0 => 
          array (
            'label' => 'Primary Investments',
            'path' => '/primary',
          ),
          1 => 
          array (
            'label' => 'Secondary Opportunities',
            'path' => '/secondary',
          ),
          2 => 
          array (
            'label' => 'Unlisted Shares',
            'path' => '/unlisted',
          ),
        ),
      ),
      3 => 
      array (
        'label' => 'How It Works',
        'path' => '/how-it-works',
      ),
      4 => 
      array (
        'label' => 'Contact Us',
        'path' => '/contact',
      ),
    ),
    'footer_company' => 
    array (
      0 => 
      array (
        'label' => 'Home',
        'path' => '/',
      ),
      1 => 
      array (
        'label' => 'About Us',
        'path' => '/about',
      ),
      2 => 
      array (
        'label' => 'Investment Opportunities',
        'path' => '/opportunities',
      ),
      3 => 
      array (
        'label' => 'How It Works',
        'path' => '/how-it-works',
      ),
      4 => 
      array (
        'label' => 'Contact Us',
        'path' => '/contact',
      ),
    ),
    'footer_legal' => 
    array (
      0 => 
      array (
        'label' => 'Privacy Policy',
        'path' => '/privacy-policy',
      ),
      1 => 
      array (
        'label' => 'Terms & Conditions',
        'path' => '/terms-conditions',
      ),
      2 => 
      array (
        'label' => 'Risk Disclosure',
        'path' => '/risk-disclosure',
      ),
      3 => 
      array (
        'label' => 'Disclaimer',
        'path' => '/disclaimer',
      ),
    ),
  ),
  'pages' => 
  array (
    'home' => 
    array (
      'slug' => 'home',
      'path' => '/',
      'sitemap' => true,
      'priority' => 1.0,
      'changeFrequency' => 'weekly',
      'title' => 'Private Deals | Private Markets. Built for Wealth Partners.',
      'description' => 'Private Deals helps wealth partners discover, evaluate and offer curated private-market opportunities across Private Equity, LP Secondary and Unlisted Shares.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'index.html',
    ),
    'about' => 
    array (
      'slug' => 'about',
      'path' => '/about',
      'sitemap' => true,
      'priority' => 0.8,
      'changeFrequency' => 'monthly',
      'title' => 'About Us | Private Deals',
      'description' => 'Private Deals helps wealth partners access and manage private markets—opportunities, research, transactions and post-investment tools in one platform.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'about.html',
    ),
    'opportunities' => 
    array (
      'slug' => 'opportunities',
      'path' => '/opportunities',
      'sitemap' => true,
      'priority' => 0.9,
      'changeFrequency' => 'weekly',
      'title' => 'Investment Opportunities | Private Deals',
      'description' => 'Explore primary investments, LP secondary opportunities and unlisted shares on Private Deals—the private-markets platform built for wealth partners.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'opportunities.html',
    ),
    'primary' => 
    array (
      'slug' => 'primary',
      'path' => '/primary',
      'sitemap' => true,
      'priority' => 0.8,
      'changeFrequency' => 'weekly',
      'title' => 'Primary Investments | Private Deals',
      'description' => 'Invest in companies raising capital via Private Deals. Primary opportunities for wealth partners with research and digital transaction support.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'primary.html',
    ),
    'secondary' => 
    array (
      'slug' => 'secondary',
      'path' => '/secondary',
      'sitemap' => true,
      'priority' => 0.8,
      'changeFrequency' => 'weekly',
      'title' => 'Secondary Opportunities | Private Deals',
      'description' => 'Access existing shares in private companies via Private Deals. Evaluate LP secondary opportunities with pricing, share details and digital transfer.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'secondary.html',
    ),
    'unlisted' => 
    array (
      'slug' => 'unlisted',
      'path' => '/unlisted',
      'sitemap' => true,
      'priority' => 0.8,
      'changeFrequency' => 'weekly',
      'title' => 'Unlisted Shares | Private Deals',
      'description' => 'Access unlisted and pre-IPO shares on Private Deals before companies list—company info, financials and valuation data for wealth partners. From ₹15,000.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'unlisted.html',
    ),
    'how-it-works' => 
    array (
      'slug' => 'how-it-works',
      'path' => '/how-it-works',
      'sitemap' => true,
      'priority' => 0.7,
      'changeFrequency' => 'monthly',
      'title' => 'How It Works | Private Deals',
      'description' => 'See how Private Deals takes wealth partners from discovering private-market opportunities to evaluating, investing digitally and managing client holdings.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'process.html',
    ),
    'contact' => 
    array (
      'slug' => 'contact',
      'path' => '/contact',
      'sitemap' => true,
      'priority' => 0.7,
      'changeFrequency' => 'monthly',
      'scripts' => 
      array (
        0 => 'marketing/assets/contact-form.js',
      ),
      'title' => 'Contact Us | Private Deals',
      'description' => 'Contact Private Deals for partner access and a walkthrough of private-market opportunities. Operated by Shuru Advisory Private Limited.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'contact.html',
    ),
    'login' => 
    array (
      'slug' => 'login',
      'path' => '/login',
      'sitemap' => false,
      'scripts' => 
      array (
        0 => 'marketing/assets/login-form.js',
      ),
      'title' => 'Login | Private Deals',
      'description' => 'Sign in to Private Deals. Partner access is invitation-only — request access if you are not registered yet.',
      'robots' => 'noindex, follow',
      'source' => 'login.html',
    ),
    'not-found' => 
    array (
      'slug' => 'not-found',
      'path' => '/404',
      'sitemap' => false,
      'title' => 'Page not found | Private Deals',
      'description' => 'The page you requested could not be found.',
      'robots' => 'noindex, follow',
      'source' => '404.html',
    ),
    'privacy-policy' => 
    array (
      'slug' => 'privacy-policy',
      'path' => '/privacy-policy',
      'sitemap' => true,
      'priority' => 0.3,
      'changeFrequency' => 'yearly',
      'title' => 'Privacy Policy | Private Deals',
      'description' => 'How Private Deals, operated by Shuru Advisory Private Limited, collects and uses information.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'privacy-policy.html',
    ),
    'terms-conditions' => 
    array (
      'slug' => 'terms-conditions',
      'path' => '/terms-conditions',
      'sitemap' => true,
      'priority' => 0.3,
      'changeFrequency' => 'yearly',
      'title' => 'Terms & Conditions | Private Deals',
      'description' => 'Terms and conditions for using Private Deals, operated by Shuru Advisory Private Limited.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'terms-conditions.html',
    ),
    'risk-disclosure' => 
    array (
      'slug' => 'risk-disclosure',
      'path' => '/risk-disclosure',
      'sitemap' => true,
      'priority' => 0.3,
      'changeFrequency' => 'yearly',
      'title' => 'Risk Disclosure | Private Deals',
      'description' => 'Risks associated with private-market investments offered through Private Deals.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'risk-disclosure.html',
    ),
    'disclaimer' => 
    array (
      'slug' => 'disclaimer',
      'path' => '/disclaimer',
      'sitemap' => true,
      'priority' => 0.3,
      'changeFrequency' => 'yearly',
      'title' => 'Disclaimer | Private Deals',
      'description' => 'Important disclaimers for Private Deals, operated by Shuru Advisory Private Limited.',
      'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1',
      'source' => 'disclaimer.html',
    ),
  ),
  'legacy_redirects' => 
  array (
    '/index.html' => '/',
    '/about.html' => '/about',
    '/opportunities.html' => '/opportunities',
    '/primary.html' => '/primary',
    '/secondary.html' => '/secondary',
    '/unlisted.html' => '/unlisted',
    '/process.html' => '/how-it-works',
    '/contact.html' => '/contact',
    '/login.html' => 'https://partner.privatedeals.in/sign-in',
    '/privacy-policy.html' => '/privacy-policy',
    '/terms-conditions.html' => '/terms-conditions',
    '/risk-disclosure.html' => '/risk-disclosure',
    '/disclaimer.html' => '/disclaimer',
  ),
);
