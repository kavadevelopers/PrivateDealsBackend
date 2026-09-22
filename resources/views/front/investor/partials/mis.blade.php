<div class="top_status_content mis-item">
    <div class="all-p-cards">
        <div class="card-p-custom">
            <div class="user_info">
                <div class="logo">
                    <img class="lazy shimmer"data-src="{{ FileUpDownHelper::get_startup_logo_url($item->startup) }}">
                </div>
                <div class="name_type">
                    <h3>{{ $item->startup->brand_name }}</h3>
                </div>
            </div>
            <div class="descriptions">
                <p>
                    Total MIS Uploded :
                    <span class="bold">{{ count($item->startup->approvedMis) }}</span>
                </p>
            </div>
        </div>
        <div class="expand_details">
            <button class="details" type="button" data-bs-toggle="collapse"
                data-bs-target="#details{{ $item->startup->uuid }}" aria-expanded="false"
                aria-controls="collapseExample">
                <span class="show">Show All</span>
                <i class="fa-solid fa-angle-down"></i>
            </button>
            <div class="collapse" id="details{{ $item->startup->uuid }}">
                <div class="card card-body">
                    <div class="table_scroll">
                        <table class="responsive">
                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->startup->approvedMis as $mKey => $mis)
                                    <tr>
                                        <td>{{ $mKey + 1 }}</td>
                                        <td>{{ UtillsHelper::read_more_hide($mis->title, 20) }}</td>
                                        <td>{!! UtillsHelper::read_more_popup($mis->description, 30) !!}</td>
                                        <td class="actions">
                                            <a href="{{ route('download.web', ['path' => $mis->document, 'name' => 'MIS_' . $item->startup->brand_name . '_' . $mis->title]) }}"
                                                class="btn_custom_line download"><i class="fa fa-download"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
