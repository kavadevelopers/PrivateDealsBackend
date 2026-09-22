<?php

namespace App\Http\Middleware;

use App\Helpers\CommonHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Factory as ViewFactory;

class EnsureSeoMetaTags
{
    /**
     * Create a new middleware instance.
     */
    public function __construct(protected ViewFactory $view)
    {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Get current view data
        $data = $this->view->getShared();

        // Ensure critical SEO variables are set
        if (!isset($data['metaDescription']) || empty($data['metaDescription'])) {
            $this->view->share('metaDescription', $this->getDefaultMetaDescription($request));
        }

        if (!isset($data['metaKeywords']) || empty($data['metaKeywords'])) {
            $this->view->share('metaKeywords', CommonHelper::appSettings('app_meta_keywords') ?? 'startup investment, equity, pre-IPO, India');
        }

        if (!isset($data['ogImage']) || empty($data['ogImage'])) {
            $this->view->share('ogImage', asset('core/images/og-image.png'));
        }

        if (!isset($data['canonicalUrl']) || empty($data['canonicalUrl'])) {
            $this->view->share('canonicalUrl', $request->url());
        }

        return $response;
    }

    /**
     * Get default meta description based on route
     */
    private function getDefaultMetaDescription(Request $request): string
    {
        $defaults = [
            'front.home' => 'Invest in startups, primary market, secondary market, and pre-IPO opportunities on India\'s leading equity investment platform. Start your investment journey today.',
            'front.abt' => 'Learn about Shuruup - India\'s premier platform for startup investments, pre-IPO trading, and equity opportunities.',
            'front.terminal' => 'Smart Investing Terminal - Advanced tools and insights for modern investors.',
            'front.cards.startup' => 'Startup Investment Opportunities - Invest in India\'s most promising startups with Shuruup.',
            'front.cards.primary' => 'Primary Market Investments - Access new equity offerings from established companies.',
            'front.cards.secondary' => 'Secondary Market - Trade pre-IPO and unlisted shares on India\'s leading platform.',
            'front.cards.preipo' => 'Pre-IPO Investments - Invest in companies before their IPO with verified opportunities.',
            'front.team' => 'Meet the Shuruup team - Experts dedicated to making equity investment accessible to all Indians.',
            'front.contactus.get' => 'Contact Shuruup - Get in touch with our team for any questions or support.',
            'front.disclaimer' => 'Important disclaimer and risk disclosures for equity investments on Shuruup.',
            'front.privacypolicy' => 'Privacy Policy - How Shuruup protects and handles your personal information.',
            'front.termsofuse' => 'Terms of Use - Shuruup\'s terms and conditions for using our platform.',
            'front.riskdisclouser' => 'Risk Disclosure - Understanding the risks of equity investment opportunities.',
        ];

        $routeName = $request->route()?->getName();

        return $defaults[$routeName] ?? CommonHelper::appSettings('app_meta_description') ?? 'India\'s premier platform for startup investments, primary transactions, secondary market, and pre-IPO opportunities.';
    }
}
