<form class="" action="{{ route('front.investor.checkMandate') }}" method="post" id="step2form" enctype="multipart/form-data">
    @csrf
    
        <div class="invest_details">
            <h4>Mandate Registration & SSA Generation</h4>
            {{-- <h4>Termsheet Generation</h4> --}}
        </div>
        <div class="ui_content mandate-input">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="d_field_group">
                        <label>Bank <span class="-req">*</span></label>
                        <select required class="d_select" name="bank">
                            <option value="">-- Select --</option>
                            @foreach (App\Models\MasterBankModel::where('is_deleted','0')->get() as $key => $value)
                                <option value="{{ $value->name }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d_field_group">
                        <label>Account holder name <span class="-req">*</span></label>
                        <input type="text" class="d_field"  name="ac_name" value="" placeholder="Enter Account holder name" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d_field_group">
                        <label>Bank Ac/No. <span class="-req">*</span></label>
                        <input type="text" class="d_field numbers"  name="ac_no" value="" placeholder="Enter Bank Ac/No." required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d_field_group">
                        <label>IFSC/MICR Code <span class="-req">*</span></label>
                        <input type="text" class="d_field"  name="ifsc" value="" placeholder="Enter IFSC/MICR Code" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" required>
                    </div>
                </div>
            </div>
        </div>
        <div>
        <input type="hidden" name="mandateid" >
        <input type="hidden" name="startup" >
        <input type="hidden" name="investment_id_step2" value="{{ isset($inv_id)?$inv_id:'' }}">
        <button class="btn_custom" type="submit">Save</button>
    </div>
    </form>
  