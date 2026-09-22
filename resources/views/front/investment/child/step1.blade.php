
        <form class="" action="#" data-action="{{ route('front.investor.investStep1') }}" method="post" id="step1form" enctype="multipart/form-data">
            @csrf
            <div class="field_group">
                <label>How much do you want to invest?</label>
                <input class="field decimal-num" type="text" autocomplete="off" name="amount" placeholder="Enter Amount" required>
                <i class="fa-solid fa-indian-rupee-sign input_icon"></i>
                <div class="errorInvest">
                    
                </div>
            </div>
            <div class="input_preset" id="multiple-amount-suggestions" style="display: none;">
                <p>To own a whole number of shares you must enter and amount that is a multiple of
                    <span class="bold">{{ $startup->pshareprice  }}</span>
                    such as:</p>
                <div class="preset_btn">
                    <button class="btn_custom_line knxSEh sugAmt1" type="button" data-amount="100">₹11.34</button> 
                        <span>or</span>
                    <button class="btn_custom_line knxSEh sugAmt2" type="button" data-amount="100">₹11.34</button>
                </div>
            </div>
            <p class="notice">The minimum investment is  {{ $startup->StartupFundRaiseOne->min_ticket_size * $startup->lastRounds->share_price }}</p>
            <div class="invest_details" style="margin-top: 15px;">
                <h4>Investment details</h4>
                <!-- <p>Investment amount : <span class="bold">₹13000</span></p>
                <p>No. of shares : <span class="bold">16%</span></p> -->
                <p>Share type : <span class="bold">{{ $startupdet->stype }}</span></p>
                <p>Share price : <span class="bold"> {{ UtillsHelper::moneyFormatIndia($startup->lastRounds->share_price) }} </span></p>
            </div>
            <div class="invest_details">
                <h4>Payment type</h4>
                <ul class="cus-btn-radios">
                    <li>
                        <input type="radio" id="radiomandate" name="payment_mode" value="1"/>
                        <label for="radiomandate">E-Mandate</label>
                    </li>
                    <li>
                        <input type="radio" id="radiortgs" name="payment_mode" value="2"/>
                        <label for="radiortgs">RTGS</label>
                    </li>
                    <li>
                        <input type="radio" id="radiocheque" name="payment_mode" value="3"/>
                        <label for="radiocheque">Cheque</label>
                    </li>
                </ul>
            </div>
            <br><br>
            <div class="check_agree" style="width: 100%; margin-top:20px;">
                <input type="checkbox" name="agree" id="agree" value="Accept agreement" required>
                <label for="agree">I have read and agree to the <a href="{{ url('themes/doc/investment-disclosures.pdf') }}" target="_blank" class="red_link">Investment Agreement</a></label>
            </div>
            <button type="submit" class="btn_custom" name="submit">Proceed</button>
            <input type="hidden" name="iserror" value="1">
            <input type="hidden" name="startup" value="{{ $startup->id }}">
            {{-- <input type="hidden" name="investment" value="{{ $investment->id }}"> --}}
        </form>
@push('custom-scripts')
    <script src="{{ asset('front-assets/js/custom/auth/investor/invest.js') }}"></script>
@endpush
@push('script')
<script type="text/javascript">
    $(function(){
        $('#step1form input[name=payment_mode]').change(function(){
            if($('#step1form input[name=payment_mode]:checked').val() == '1'){
                $('#modalInfoPopupItem .modal-title').html('E-Mandate');
                $('#modalInfoPopupItem .info_body').html('The E-Mandate is like ASBA (Application Supported by Blocked Amount) in IPO. The only difference is that in E-Mandate, the money will not be blocked, so you don’t need to initially maintain balance while applying. Once all documentations are done, the start-up will request to pull funds from the mandate to the start-up’s share application account.');
            }else if($('#step1form input[name=payment_mode]:checked').val() == '2'){
                $('#modalInfoPopupItem .modal-title').html('RTGS');
                $('#modalInfoPopupItem .info_body').html('In RTGS, you will complete all the documentations required for private placement. After signing the offer letter, you will be requested to initiate the fund transfer to the start-up’s share application account.');
            }else{
                $('#modalInfoPopupItem .modal-title').html('Cheque');
                $('#modalInfoPopupItem .info_body').html('In cheque, you will complete all the documentations required for private placement. After signing the offer letter, you will be requested to deposit the cheque in favor of start-up’s share application account.');
            }
            $('#modalInfoPopupItem').modal('show');
        });    
        $('#step1form input[name=agree]').change(function(){
            if ($(this).is(':checked')) {
                $('#step1form button[name=submit]').removeAttr('disabled');
            }else{
                $('#step1form button[name=submit]').attr('disabled',true);
            }
        });
    })
</script>
@endpush

