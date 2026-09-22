@extends('front.layouts.master')
{{-- @include('front.layouts.iheader') --}}

@section('content')
    <?php
    $investment = App\Models\PrimaryTransactionModel::where('startup_id', $startup->id)
        ->where('investor_id', Auth::guard('investor')->user()->id)
        ->first();
    if (!$investment) {
        $investment = App\Models\PrimaryTransactionModel::create([
            'status' => '0',
            'startup_id' => $startup->id,
            'investor_id' => Auth::guard('investor')->user()->id,
            'investment_amount' => 0.0,
            'shares' => 0.0,
            'share_price' => 0.0,
            // 'instrument'                => Common::getKeyOfInstrument($startupdet->stype)
        ]);
    }
    ?>


    <div class="startup_invest">
        <div id="main">
            <div class="container_custom">
                <div class="content">
                    <div class="invest_left">
                        <h3>{{ $_title }}</h3>
                        <div class="input_form" id="dynamicContent">
                            {{-- {{ dd($investment); }} --}}
                            @if ($investment->status == 0)
                                @include('front.investment.child.step1')
                            @elseif ($investment->status == 1)
                                @include('front.investment.child.step2', ['inv_id' => $investment->id])
                            @elseif ($investment->status == 2)
                                @include('front.investment.child.step3', ['inv_id' => $investment->id])
                            @else
                                @include('front.investment.child.inprocess')
                            @endif
                        </div>
                    </div>
                    <div class="invest_right">
                        <a href="javascript:;" class="invest_card">
                            <div class="video">
                                <video class="card_video" src="{{ FileUpDownHelper::getStartupVideo($startup) }}"
                                    poster="{{ FileUpDownHelper::getStartupBanner($startup) }}" controlsList="nodownload"
                                    loop muted></video>
                            </div>
                            <div class="card_body_info">
                                <div class="co_profile">
                                    <div class="logo">
                                        <img src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}" alt="">
                                    </div>
                                    <div class="info">
                                        <h3>{{ UtillsHelper::read_more_hide($startup->brand_name, 15) }}</h3>
                                        <p>by: {{ UtillsHelper::read_more_hide($startup->representative_name, 20) }}</p>
                                    </div>
                                </div>
                                <div class="more_info">
                                    <p>Investment amount : <span class="bold"
                                            id="investmentAmtFinal">{{ $investment->investment_amount }}</span></p>
                                    <p>No. of shares : <span class="bold"
                                            id="investmentShareFinal">{{ $investment->shares }}</span></p>
                                    <p>Share type : <span class="bold">{{-- $startupdet->stype --}}</span></p>
                                    <p>Share price : <span class="bold">{{ $startup->lastRounds->share_price }}</span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <input type="hidden" name="" value="{{ $startup->StartupFundRaiseOne->min_ticket_size }}">
    <input type="hidden" name="pershareprice" value="{{ $startup->lastRounds->share_price }}">
    <input type="hidden" name="startupid" value="{{ $startup->id }}">
    <input type="hidden" name="investment_id" value="{{ $investment->id }}">
    @push('custom-scripts')
        <script type="text/javascript">
            $(function() {
                $(document).on('submit', '#step2form', function(e) {
                    e.preventDefault();
                    var AjaxParam = {
                        'url': "{{ url('bank-mandates/check') }}",
                        'data': $(this).serialize(),
                        'dataType': 'json',
                        'successCb': handleCreateMandate
                    };
                    doAjax(AjaxParam);
                });
                minInvest = parseFloat(
                    {{ $startup->StartupFundRaiseOne->min_ticket_size * $startup->lastRounds->share_price }});
                $('input[name=amount]').keyup(function() {
                    if ($(this).val() != "") {
                        if (minInvest > $(this).val()) {
                            $('#multiple-amount-suggestions').hide();
                            $('.errorInvest').html(
                                '<p style="color:red;margin-bottom:0;">Please enter a value greater than or equal to ₹{{ UtillsHelper::moneyFormatIndia($startup->StartupFundRaiseOne->min_ticket_size * $startup->lastRounds->share_price) }}.</p>'
                                );
                            $('input[name=iserror]').val('1');
                        } else {
                            $('.errorInvest').html('');
                            number = parseFloat($(this).val()) / parseFloat($('input[name=pershareprice]')
                            .val());
                            if (number % 1 != 0) {
                                number = parseInt(parseFloat($(this).val()) / parseFloat($(
                                    'input[name=pershareprice]').val()));
                                num1 = number;
                                num2 = parseInt(number + 1);
                                $('.errorInvest').html('');
                                $('#multiple-amount-suggestions').show();
                                $('.sugAmt1').html(num1 * parseFloat($('input[name=pershareprice]').val()));
                                $('.sugAmt1').attr('data-amount', num1 * parseFloat($(
                                    'input[name=pershareprice]').val()));
                                $('.sugAmt2').html(num2 * parseFloat($('input[name=pershareprice]').val()));
                                $('.sugAmt2').attr('data-amount', num2 * parseFloat($(
                                    'input[name=pershareprice]').val()));
                                $('input[name=iserror]').val('1');
                            } else {
                                $('input[name=iserror]').val('0');
                                $('#multiple-amount-suggestions').hide();
                                $('.errorInvest').html('');
                            }
                        }
                    } else {
                        $('input[name=iserror]').val('1');
                        $('.errorInvest').html('');
                        $('#multiple-amount-suggestions').hide();
                    }
                });

                $('.knxSEh').click(function() {
                    $('input[name=iserror]').val('0');
                    $('input[name=amount]').val($(this).data('amount'));
                    $('#multiple-amount-suggestions').hide();
                    inDisplay();
                });

                $('input[name=amount]').keyup(function() {
                    inDisplay();
                });

            });


            function handleCreateMandate(res) {
                console.log(res);
                if (res.status._return) {

                    if (res.is_demo == '1') {
                        addMandateToDB(res.mandate_id);
                    } else {
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        var options = {
                            environment: 'production',
                            "callback": function(t) {
                                console.log(t);
                                if (t.error_code != undefined) {
                                    notifyF('Mandate registration failed. Please try again later.', 'error');
                                    digio.cancel();
                                    //addMandateToDB(res.data.id);
                                } else {
                                    addMandateToDB(res.status.data.id);
                                    // myConsole(t);
                                }
                                digio.cancel();
                            },
                            logo: "{{ url('themes/logos/logo.png') }}",
                            is_iframe: true,
                            dg_preferred_auth_type: 'debit'
                        };
                        var digio = new Digio(options);
                        digio.init();
                        digio.submit(res.status.data.id, res.status.mobile, res.status.token);
                    }
                } else {
                    console.log(res.status.msg, 'error');
                }
            }

            function addMandateToDB(mandateId) {
                alert('addMandateToDB');
                $('input[name=mandateid]').val(mandateId);
                $('input[name=startup]').val($('input[name=startupid]').val());
                var AjaxParam = {
                    'url': "{{ url('investment/step2') }}",
                    'data': $('#step2form').serialize(),
                    'dataType': 'json',
                    'successCb': getMandateToDB
                };
                doAjax(AjaxParam);
            }

            function getMandateToDB(res) {
                console.log(res);
                if (res.status._return) {
                    $('#dynamicContent').html(res.status.view);
                } else {
                    console.log(res.status.msg, 'error');
                }
            }

            function inDisplay() {
                number = parseFloat($('input[name=amount]').val()) / parseFloat($('input[name=pershareprice]').val());
                if (number % 1 != 0) {
                    $('#investmentShareFinal').html(0);
                } else {
                    $('#investmentShareFinal').html(number);
                }
                $('#investmentAmtFinal').text($('input[name=amount]').val());
            }
        </script>
    @endpush
@stop
