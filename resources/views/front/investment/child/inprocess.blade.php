<form action="" method="post" id="step2form">
    {{ csrf_field() }}
        <div class="invest_details">
            <h4>In Progress</h4>
        </div>
    <div class="row">
        <div class="col-md-12">
            <img src="{{ url('weba/assets/images/in-progress.png') }}" style="width:100%;">
        </div>
    </div>
    </form>