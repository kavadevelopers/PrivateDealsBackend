<table>
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Mobile No</th>
            <th>Subject</th>
            <th>Description</th>
            <th>User Type</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ ucfirst($item->firstname) }}</td>
            <td>{{ ucfirst($item->lastname) }}</td>
            <td>{{ ucfirst($item->company) }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->mobile_no }}</td>
            <td>{{ ucfirst($item->subject) }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ ucfirst($item->user_type) }}</td>
            <td>{{ $item->created_at ? $item->created_at->format('d M Y, h:i A') : '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>