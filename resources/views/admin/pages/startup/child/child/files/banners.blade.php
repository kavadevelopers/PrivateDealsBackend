<div class="d-flex flex-wrap gap-10 mb-5">
    <div class="fv-row w-100 flex-md-root">
        <label class="form-label">Logo</label>
        <div>
            <div class="symbol symbol-50px symbol-2by3">
                <img class="" src="{{ FileUpDownHelper::get_startup_logo_url($startup) }}" alt=""
                    style="background: lightgray;" />
            </div>
        </div>
    </div>
    <div class="fv-row w-100 flex-md-root">
        <label class="form-label">Banner</label>
        <div>
            <div class="symbol symbol-2by3">
                <img class="" src="{{ FileUpDownHelper::getStartupBanner($startup) }}" alt="" />
            </div>
        </div>
    </div>
    <div class="fv-row w-100 flex-md-root">
        <label class="form-label">Long Banner</label>
        <div>
            <div class="symbol symbol-2by3">
                <img class="" src="{{ FileUpDownHelper::getStartupBannerLong($startup) }}" alt="" />
            </div>
        </div>
    </div>
</div>
