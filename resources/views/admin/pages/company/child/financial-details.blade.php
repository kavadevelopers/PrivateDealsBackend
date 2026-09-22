@if (is_array($cusItemData))
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-sm btn-primary me-2" 
            onclick="openEditModal('{{ $dataId }}', '{{ $cusItem->label }}')">
            <i class="fas fa-edit"></i> Edit Data
        </button>
        <button type="button" class="btn btn-sm btn-success" 
            onclick="openAddYearModal('{{ $dataId }}', '{{ $cusItem->label }}')">
            <i class="fas fa-plus"></i> Add Year
        </button>
    </div>

    <table class="table table-bordered table-mini">
        <thead>
            <tr>
                @foreach ($cusItemData[0] as $headerCell)
                    <th>{{ $headerCell }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($cusItemData as $index => $rowData)
                @if ($index > 0)
                    <tr>
                        @foreach ($rowData as $cellIndex => $cellData)
                            @if ($cellIndex === 0)
                                <th>{{ $cellData }}</th>
                            @else
                                <td>{{ $cellData }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif
