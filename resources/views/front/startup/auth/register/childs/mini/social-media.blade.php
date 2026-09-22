<div class="member startup-social-media-link">
    <div class="member_head">
        <h3 class="title"></h3>
        <button type="button" class="icon btn-remove-social-media"><i class="fa-solid fa-trash"></i></button>
    </div>
    <div class="member_body">
        <div class="group">
            <div class="field_group">
                <label>Select Link Type <span class="required">*</span></label>
                <select required class="select" name="socialtype[]">
                    <option value="">-- Select --</option>
                    @foreach (UtillsHelper::getSocialMediaType() as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}
                        </option>
                    @endforeach
                </select>
                <i class="fa-solid fa-link input_icon"></i>
            </div>
            <div class="field_group">
                <label>Link <span class="required">*</span></label>
                <input required class="field" type="text" name="sociallink[]" placeholder="Enter URL">
                <i class="fa-solid fa-link input_icon"></i>
            </div>
        </div>
    </div>
</div>
