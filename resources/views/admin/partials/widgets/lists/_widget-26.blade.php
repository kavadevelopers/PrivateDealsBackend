{{--
<!--begin::List widget 26-->
<div class="card card-flush h-lg-50">
	<!--begin::Header-->
	<div class="card-header pt-5">
		<!--begin::Title-->
		<h3 class="card-title text-gray-800 fw-bold">External Links</h3>
		<!--end::Title-->
		<!--begin::Toolbar-->
		<div class="card-toolbar">
			<!--begin::Menu-->
			<button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
				data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">{!!
				getIcon('dots-square', 'fs-1 text-gray-300 me-n1') !!}</button>
			<!--begin::Menu 2-->
			<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
				data-kt-menu="true">
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu separator-->
				<div class="separator mb-3 opacity-75"></div>
				<!--end::Menu separator-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3">New Ticket</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3">New Customer</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
					<!--begin::Menu item-->
					<a href="#" class="menu-link px-3">
						<span class="menu-title">New Group</span>
						<span class="menu-arrow"></span>
					</a>
					<!--end::Menu item-->
					<!--begin::Menu sub-->
					<div class="menu-sub menu-sub-dropdown w-175px py-4">
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="#" class="menu-link px-3">Admin Group</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="#" class="menu-link px-3">Staff Group</a>
						</div>
						<!--end::Menu item-->
						<!--begin::Menu item-->
						<div class="menu-item px-3">
							<a href="#" class="menu-link px-3">Member Group</a>
						</div>
						<!--end::Menu item-->
					</div>
					<!--end::Menu sub-->
				</div>
				<!--end::Menu item-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<a href="#" class="menu-link px-3">New Contact</a>
				</div>
				<!--end::Menu item-->
				<!--begin::Menu separator-->
				<div class="separator mt-3 opacity-75"></div>
				<!--end::Menu separator-->
				<!--begin::Menu item-->
				<div class="menu-item px-3">
					<div class="menu-content px-3 py-3">
						<a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
					</div>
				</div>
				<!--end::Menu item-->
			</div>
			<!--end::Menu 2-->
			<!--end::Menu-->
		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Header-->
	<!--begin::Body-->
	<div class="card-body pt-5">
		<!--begin::Item-->
		<div class="d-flex flex-stack">
			<!--begin::Section-->
			<a href="#" class="text-primary fw-semibold fs-6 me-2">Avg. Client Rating</a>
			<!--end::Section-->
			<!--begin::Action-->
			<button type="button"
				class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">{!!
				getIcon('exit-right-corner', 'fs-2') !!}</button>
			<!--end::Action-->
		</div>
		<!--end::Item-->
		<!--begin::Separator-->
		<div class="separator separator-dashed my-3"></div>
		<!--end::Separator-->
		<!--begin::Item-->
		<div class="d-flex flex-stack">
			<!--begin::Section-->
			<a href="#" class="text-primary fw-semibold fs-6 me-2">Instagram Followers</a>
			<!--end::Section-->
			<!--begin::Action-->
			<button type="button"
				class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">{!!
				getIcon('exit-right-corner', 'fs-2') !!}</button>
			<!--end::Action-->
		</div>
		<!--end::Item-->
		<!--begin::Separator-->
		<div class="separator separator-dashed my-3"></div>
		<!--end::Separator-->
		<!--begin::Item-->
		<div class="d-flex flex-stack">
			<!--begin::Section-->
			<a href="#" class="text-primary fw-semibold fs-6 me-2">Google Ads CPC</a>
			<!--end::Section-->
			<!--begin::Action-->
			<button type="button"
				class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">{!!
				getIcon('exit-right-corner', 'fs-2') !!}</button>
			<!--end::Action-->
		</div>
		<!--end::Item-->
	</div>
	<!--end::Body-->
</div>
<!--end::LIst widget 26--> --}}

<div class="card card-flush shadow-lg border-0 w-100" style="min-height: 320px; min-width: 300px;">
	<div class="card-header pt-4 pb-0">
		<h3 class="card-title fw-bold text-gray-900 mb-2">Quick Stats</h3>
	</div>
	<div class="card-body py-4" style="height:100%;">
		<div class="d-flex flex-column gap-3" style="height:100%;">
			@foreach([
			['label' => 'Requests Pending', 'value' => $request_access, 'color' => 'bg-warning', 'icon' =>
			'bi-exclamation-circle-fill text-warning'],
			['label' => 'Active Investors Today', 'value' => $active_user_today, 'color' => 'bg-success', 'icon' =>
			'bi-person-fill text-success'],
			['label' => 'Active Partners Today', 'value' => $active_partner_today, 'color' => 'bg-primary', 'icon' =>
			'bi-people-fill text-primary'],
			['label' => 'New Investors After June', 'value' => $recent_registered_investors, 'color' =>
			'bg-purple', 'icon' => 'bi-person-plus-fill text-info'],
			['label' => 'Total Investors', 'value' => $total_user, 'color' => 'bg-secondary', 'icon' => 'bi-stack
			text-secondary'],
			['label' => 'Total Partners', 'value' => $total_partner, 'color' => 'bg-secondary', 'icon' => 'bi-stack
			text-secondary']
			] as $stat)
			<div class="d-flex justify-content-between align-items-center px-2 py-2 rounded bg-light flex-wrap w-100"
				style="min-height:42px;">
				<div class="d-flex align-items-center" style="min-width: 0;">
					<i class="bi {{ $stat['icon'] }} me-2 fs-5"></i>
					<span class="fw-semibold text-gray-800" style="white-space:normal;word-break:break-word;">
						{{ $stat['label'] }}
					</span>
				</div>
				<span class="badge rounded-pill fs-6 px-3 py-2 {{ $stat['color'] }}"
					style="min-width:38px; text-align:center;">{{ $stat['value'] }}</span>
			</div>
			@endforeach
		</div>
	</div>
</div>