<div class="member startup-team-item">
    <div class="member_head">
        <h3 class="title"></h3>
        <button class="icon btn-removeTeam" type="button"><i class="fa-solid fa-trash"></i></button>
    </div>
    <div class="member_body">
        <div class="group">
            <div class="field_group">
                <label>Name <span class="required">*</span></label>
                <input class="field" type="text" name="teamname[]" placeholder="Enter Name" required>
                <i class="fa-solid fa-user input_icon"></i>
            </div>

            <div class="field_group">
                <label><span>Photo <span class="required">*</span></span>
                    <span class="info">Photo Size Should Be (512 X 512 ,1024 X
                        1024)px</span></label>
                <input class="file" type="file" name="teamphoto[]"
                    onchange="fileExAllowedWithSize(this,'.png,.jpg,.jpeg','{{ CommonHelper::appSettings('file_image_max_size') }}')"
                    required>
                <i class="fa-solid fa-image input_icon"></i>
            </div>



            <div class="field_group">
                <label>Linkedin Link <span class="required">*</span></label>
                <input class="field" type="text" name="linkedinlink[]" placeholder="Enter LinkedIn Link" required>
                <i class="fa-solid fa-link input_icon"></i>
            </div>

            <div class="field_group">
                <label>Designation <span class="required">*</span></label>
                <input class="field" type="text" name="teamdesignation[]" placeholder="Enter Designation" required>
                <i class="fa-solid fa-briefcase input_icon"></i>
            </div>
        </div>
        <div class="field_group">
            <label>Brief Introduction <span class="required">*</span></label>
            <textarea class="big_field" name="teaminfo[]" placeholder="Enter Brief Introduction" required></textarea>
            <i class="fa-solid fa-location-dot input_icon"></i>
        </div>
    </div>
    <input type="hidden" name="teamid[]" value="">
</div>
