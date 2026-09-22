<!--begin::Menu-->

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('kt_menu_notifications').addEventListener('DOMSubtreeModified', function() {
            // @this.dispatch('refreshNotifications');
            console.log(this.$wire);
            // this.$wire.$loadNotifications();
        });
    });
</script>
@script
    <script>
        console.log(this.$wire);
    </script>
@endscript --}}
<div>
    <!--begin::Heading-->
    <div class="d-flex flex-column bgi-no-repeat rounded-top"
        style="background-image:url('{{ asset('assets/media/misc/menu-header-bg.jpg') }}')">
        <!--begin::Title-->
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
            {{-- <span class="fs-8 opacity-75 ps-3">15</span> --}}
        </h3>
        <!--end::Title-->
        <!--begin::Tabs-->
        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
            {{-- <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_1">Alerts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_2">Updates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_3">Logs</a>
            </li> --}}
        </ul>
        <!--end::Tabs-->
    </div>
    <!--end::Heading-->
    <!--begin::Tab content-->
    <div class="tab-content">
        <!--begin::Tab panel-->
        <div class="tab-pane fade show active" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8">
                <div class="load">
                    @include('admin.partials.loaders.child')
                </div>
                <div class="data">

                </div>

            </div>
            <div class="py-3 text-center border-top view-all">
                <a href="{{ route('admin.profile.notification.list') }}"
                    class="btn btn-color-gray-600 btn-active-color-primary">View All
                    {!! getIcon('arrow-right', 'fs-5') !!}</a>
            </div>
        </div>
        {{-- <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8">
                @foreach ($notifications as $item)
                    <!--begin::Item-->
                    <div class="d-flex flex-stack py-4">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-35px me-4">
                                <span class="symbol-label bg-light-primary">{!! getIcon('abstract-28', 'fs-2 text-primary') !!}</span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="mb-0 me-2">
                                <a href="#"
                                    class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $item->title }}-{{ $item->id }}</a>
                                <div class="text-gray-500 fs-7">Phase 1 development</div>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Section-->

                        <span class="badge badge-light fs-8">1 hr</span>

                    </div>
                    <!--end::Item-->
                @endforeach

            </div>
            <div class="py-3 text-center border-top">
                <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">View All
                    {!! getIcon('arrow-right', 'fs-5') !!}</a>
            </div>
        </div> --}}
    </div>
</div>
