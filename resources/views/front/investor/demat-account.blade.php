@extends('front.layouts.dashboard')

@section('child-content')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="ui_content">
                <h3>{{ getPageTitle() }}</h3>
                <div class="d_card">
                    <form action="{{ route('front.investor.demat.post') }}" method="post" id="changePassForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>DP Id <span class="required">*</span></label>
                                    <input type="text" class="d_field" name="dp_id"
                                        value="{{ $investor->dematAccount ? $investor->dematAccount->dp_id : '' }}"
                                        placeholder="Enter DP Id" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Client Id</label>
                                    <input type="text" class="d_field" name="client_id"
                                        value="{{ $investor->dematAccount ? $investor->dematAccount->client_id : '' }}"
                                        placeholder="Enter Client Id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d_field_group">
                                    <label>Demat account number</label>
                                    <input type="text" class="d_field" name="demat_account"
                                        value="{{ $investor->dematAccount ? $investor->dematAccount->demat_account : '' }}"
                                        placeholder="Enter Demat account number">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <button class="btn_custom" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
