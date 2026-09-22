<div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    @if (request()->routeIs('front.raise.*'))
        <a href="{{ route('front.raise.dashboard') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.dashboard') ? 'active' : '' }}">
                <span class="fa-solid fa-gauge-high"></span><span>Dashboard</span>
            </button>
        </a>
        <a href="{{ route('front.raise.manageCaptable.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.manageCaptable*') ? 'active' : '' }}">
                <span class="fa-solid fa-gauge-high"></span><span>Manage Captable</span>
            </button>
        </a>
        <a href="{{ route('front.raise.primaryTransaction') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.primaryTransaction*') ? 'active' : '' }}">
                <span class="fa-solid fa-bank"></span><span>Transaction</span>
            </button>
        </a>
        <a href="{{ route('front.raise.mgt14.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.mgt14*') ? 'active' : '' }}">
                <span class="fa-solid fa-file"></span><span>MGT14</span>
            </button>
        </a>
        @include('front.partials.childs.sidebar.offer-button')
        <a href="{{ route('front.raise.pas3.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.pas3*') ? 'active' : '' }}">
                <span class="fa-solid fa-file"></span><span>PAS3</span>
            </button>
        </a>
        <a href="{{ route('front.raise.sell_requests.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.sell_requests*') ? 'active' : '' }}">
                <span class="fa-solid fa-code-pull-request"></span><span>Sell Request</span>
            </button>
        </a>
        <a href="{{ route('front.raise.updates.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.updates*') ? 'active' : '' }}">
                <span class="fa-solid fa-newspaper"></span><span>Updates</span>
            </button>
        </a>

        <a href="{{ route('front.raise.mis.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.mis*') ? 'active' : '' }}">
                <span class="fa-solid fa-upload"></span><span>MIS</span>
            </button>
        </a>
        <a href="{{ route('front.raise.livepitch.upcomingpitch') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.livepitch*') ? 'active' : '' }}">
                <span class="fa-solid fa-file-excel"></span><span>Live Pitch</span>
            </button>
        </a>
        <a href="{{ route('front.raise.document') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.document*') ? 'active' : '' }}">
                <span class="fa-solid fa-file"></span><span>Document</span>
            </button>
        </a>
        <a href="{{ route('front.raise.notifications') }}">
            <button class="nav-link  {{ request()->routeIs('front.raise.notifications*') ? 'active' : '' }}">
                <span class="fa-solid fa-bell"></span><span>Notifications</span>
            </button>
        </a>
    @endif
    @if (request()->routeIs('front.investor.*'))
        <a href="{{ route('front.investor.dashboard') }}">
            <button class="nav-link {{ request()->routeIs('front.investor.dashboard') ? 'active' : '' }}">
                <span class="fa-solid fa-gauge-high"></span><span>Dashboard</span>
            </button>
        </a>
        <a href="{{ route('front.investor.primaryTransaction') }}">
            <button class="nav-link  {{ request()->routeIs('front.investor.primaryTransaction*') ? 'active' : '' }}">
                <span class="fa-solid fa-bank"></span><span>Transaction</span>
            </button>
        </a>
        <a href="{{ route('front.investor.portfolio') }}">
            <button class="nav-link  {{ request()->routeIs('front.investor.portfolio*') ? 'active' : '' }}">
                <span class="fa-solid fa-hand-holding-dollar"></span><span>Portfolio</span>
            </button>
        </a>
        <a href="{{ route('front.investor.favStartupList') }}">
            <button class="nav-link {{ request()->routeIs('front.investor.favStartupList') ? 'active' : '' }}">
                <span class="fa fa-star"></span><span>Favorites</span>
            </button>
        </a>


        <a href="{{ route('front.investor.mis') }}">
            <button class="nav-link  {{ request()->routeIs('front.investor.mis*') ? 'active' : '' }}">
                <span class="fa-solid fa-upload"></span><span>MIS</span>
            </button>
        </a>
        <a href="{{ route('front.investor.mandatelist') }}">
            <button class="nav-link  {{ request()->routeIs('front.investor.mandatelist*') ? 'active' : '' }}">
                <span class="fa-solid fa-bank"></span><span>Bank Mandates</span>
            </button>
        </a>
        <a href="{{ route('front.investor.family.list') }}">
            <button class="nav-link {{ request()->routeIs('front.investor.family.*') ? 'active' : '' }}">
                <span class="fa-solid fa-users"></span><span>My Family</span>
            </button>
        </a>
        <a href="{{ route('front.investor.document') }}">
            <button class="nav-link  {{ request()->routeIs('front.investor.document*') ? 'active' : '' }}">
                <span class="fa-solid fa-file"></span><span>Document</span>
            </button>
        </a>
        <a href="{{ route('front.investor.notifications') }}">
            <button class="nav-link  {{ request()->routeIs('front.investor.notifications*') ? 'active' : '' }}">
                <span class="fa-solid fa-bell"></span><span>Notifications</span>
            </button>
        </a>
    @endif
    @if (request()->routeIs('front.business.*'))
        <a href="{{ route('front.business.dashboard') }}">
            <button class="nav-link  {{ request()->routeIs('front.business.dashboard') ? 'active' : '' }}">
                <span class="fa-solid fa-gauge-high"></span><span>Dashboard</span>
            </button>
        </a>
        @if (Auth::guard('partner')->user()->type != \App\Enums\PartnerTypeEnum::retailer->value)
            <a href="{{ route('front.business.channel_partner.list') }}">
                <button class="nav-link  {{ request()->routeIs('front.business.channel_partner*') ? 'active' : '' }}">
                    <span class="fa-solid fa-users"></span><span>Channel Partner</span>
                </button>
            </a>
        @endif
        <a href="{{ route('front.business.primaryTransaction') }}">
            <button class="nav-link  {{ request()->routeIs('front.business.primaryTransaction*') ? 'active' : '' }}">
                <span class="fa-solid fa-bank"></span><span>Transaction</span>
            </button>
        </a>
        <a href="{{ route('front.business.investor.list') }}">
            <button class="nav-link  {{ request()->routeIs('front.business.investor*') ? 'active' : '' }}">
                <span class="fa-solid fa-user"></span><span>Investors</span>
            </button>
        </a>
        <a href="{{ route('front.business.notifications') }}">
            <button class="nav-link  {{ request()->routeIs('front.business.notifications*') ? 'active' : '' }}">
                <span class="fa-solid fa-bell"></span><span>Notifications</span>
            </button>
        </a>
        <a href="{{ route('front.business.document') }}">
            <button class="nav-link  {{ request()->routeIs('front.business.document*') ? 'active' : '' }}">
                <span class="fa-solid fa-file"></span><span>Document</span>
            </button>
        </a>
    @endif

</div>
