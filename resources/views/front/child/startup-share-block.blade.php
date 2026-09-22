<button class="share btn_custom_line"><i class="fa-solid fa-share-nodes"></i></button>
<div class="share_link bg_style">
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url('startup/'.Illuminate\Support\Facades\Crypt::encrypt($startup->id)) }}" target="_blank">
        <button class="social btn_custom"><i class="fa-brands fa-linkedin-in"></i></button>
    </a>
    {{-- <a href="https://web.whatsapp.com/send?text={{ urlencode('Check this out on '.Common::setting('app_name').' '.url('startup/'.Illuminate\Support\Facades\Crypt::encrypt($startup->id))) }}" target="_blank"> --}}
        <button class="social btn_custom"><i class="fa-brands fa-whatsapp"></i></button>
    </a>
    {{-- <a href="mailto:?Subject=Check this startup on {{ Common::setting('app_name') }}&Body=I want to recommend this startup at {{ Common::setting('app_name') }} :- {{ url('startup/'.Illuminate\Support\Facades\Crypt::encrypt($startup->id)) }}"> --}}
        <button class="social btn_custom"><i class="fa-solid fa-envelope"></i></button>
    </a>
    {{-- <a href="#" data-dcopy="{{ url('startup/'.Illuminate\Support\Facades\Crypt::encrypt($startup->id)) }}" class="btn-copy-text" target="_blank"> --}}
        <button class="social btn_custom"><i class="fa-solid fa-copy"></i></button>
    </a>
</div>