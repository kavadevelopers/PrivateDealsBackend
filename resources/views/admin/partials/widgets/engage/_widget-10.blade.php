{{--
<!--begin::Engage widget 10-->
<div class="card card-flush h-md-100">
	<!--begin::Body-->
	<div class="card-body d-flex flex-column justify-content-between mt-9 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
		style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
		<!--begin::Wrapper-->
		<div class="mb-10">
			<!--begin::Title-->
			<div class="fs-2hx fw-bold text-gray-800 text-center mb-13">
				<span class="me-2">Try our all new Enviroment with
					<br />
					<span class="position-relative d-inline-block text-danger">
						<a href="#" class="text-danger opacity-75-hover">Pro Plan</a>
						<!--begin::Separator-->
						<span
							class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
						<!--end::Separator-->
					</span></span>for Free
			</div>
			<!--end::Title-->
			<!--begin::Action-->
			<div class="text-center">
				<a href='#' class="btn btn-sm btn-dark fw-bold" data-bs-toggle="modal"
					data-bs-target="#kt_modal_upgrade_plan">Upgrade Now</a>
			</div>
			<!--begin::Action-->
		</div>
		<!--begin::Wrapper-->
		<!--begin::Illustration-->
		<img class="mx-auto h-150px h-lg-200px theme-light-show" src="{{ image('illustrations/misc/upgrade.svg') }}"
			alt="" />
		<img class="mx-auto h-150px h-lg-200px theme-dark-show" src="{{ image('illustrations/misc/upgrade-dark.svg') }}"
			alt="" />
		<!--end::Illustration-->
	</div>
	<!--end::Body-->
</div>
<!--end::Engage widget 10--> --}}

<div class="card card-flush h-md-100 shadow-lg border-0">
	<div class="card-body d-flex flex-column justify-content-between mt-9
         bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0"
		style="background-position: 100% 50%; background-image:url('{{ asset('assets/media/stock/900x600/42.png') }}');">
		<!-- Title -->
		<div class="mb-10">
			<div class="fs-2x fw-bold text-gray-800 text-center mb-2">
				Total Investments
			</div>
			<div class="fs-5 fw-semibold text-gray-600 text-center mb-5 opacity-75">
				Till Now
			</div>

			<!-- Big Amount -->
			<div class="fs-3hx fw-extrabold text-gray-900 text-center mb-4">
				₹{{ number_format($primary_total + $secondary_total + $preipo_total) }}
			</div>

			{{-- <div class="text-center">
				<a href="{{ route('admin.investments.reports') }}" class="btn btn-sm btn-dark fw-bold">
					View Full Investment Reports
				</a>
			</div> --}}
		</div>
		<!-- Illustration/Image -->
		<img class="mx-auto h-150px h-lg-200px theme-light-show" src="{{ image('illustrations/misc/upgrade.svg') }}"
			alt="Investment Growth" />
		<img class="mx-auto h-150px h-lg-200px theme-dark-show" src="{{ image('illustrations/misc/upgrade-dark.svg') }}"
			alt="Investment Growth Dark" />
	</div>
</div>