<div class="card-p-custom">
    <div class="user_info">
        <div class="logo"><img
                class="lazy shimmer"data-src="{{ FileUpDownHelper::get_startup_logo_url($item->startup) }}">
        </div>
        <div class="name_type">
            <h3>{{ $item->startup->brand_name }}</h3>
            <p>Type: <span class="bold">{{ strtoupper($item->instrument) }}</span></p>
            {{-- <span class="badge badge-sold">
                                                Sold
                                            </span> --}}
        </div>
    </div>
    <div>
        <p>Shares: <span class="bold">{{ (int) $item->shares }}</span>
        </p>
        <p>Current Share Price: <span class="bold">0</span>
        </p>
        <p>Date of Investment : <span class="bold">{{ DateTimeHelper::viewDate($item->updated_at) }}</span>
        </p>
    </div>
    <div>
        <p>Purchase Price: <span
                class="bold">{{ UtillsHelper::rupee() }}{{ UtillsHelper::moneyFormatIndia($item->purchase_price) }}</span>
        </p>
        <p>Increase/Decrease (%): <span class="bold">0</span></p>
    </div>
    <div>
        <p>Amount Invested: <span
                class="bold">{{ UtillsHelper::rupee() }}{{ UtillsHelper::moneyFormatIndia($item->investment_amount) }}</span>
        </p>
        <p>Increase/Decrease (Amt): <span class="bold">0</span></p>
        {{-- <p>Profit Booked : <span class="bold">0.00</span></p>
        <p>Sell request pending: <span class="bold">30</span></p> --}}
    </div>
    {{-- <div>
        <a href="#" class="btn_custom">
            <i class="fa-solid fa-share"></i>
            <span>Sell</span>
        </a>
    </div> --}}
</div>
