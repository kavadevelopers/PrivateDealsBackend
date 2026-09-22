<x-default-layout>
    @section('title')
        {{ getPageTitle() }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('notification.list') }}
    @endsection

    @if (count($list) > 0)
        <div class="col-xl-12">
            <div class="card card-xl-stretch mb-5 mb-xl-8">
                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-5">
                            <thead>
                                <tr>
                                    <th class="p-0 w-50px"></th>
                                    <th class="p-0 min-w-150px"></th>
                                    <th class="p-0 min-w-125px"></th>
                                    <th class="p-0 min-w-40px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-50px me-2">
                                                <span class="symbol-label bg-light-primary">
                                                    {!! getIcon('notification-on', 'fs-2 text-primary') !!}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#"
                                                class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $item->title }}</a>
                                            <span class="text-muted fw-semibold d-block fs-7">{{ $item->body }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-muted fw-bold">
                                                {{ $item->created_at->diffForHumans() }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route($item->url) }}"
                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                                                <i class="ki-duotone ki-arrow-right fs-2"><span
                                                        class="path1"></span><span class="path2"></span></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('admin.layout.partials.nodata')
    @endif
</x-default-layout>
