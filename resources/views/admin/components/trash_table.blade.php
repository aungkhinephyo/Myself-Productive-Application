<table class="table table-hover">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Deleted At</th>
            @can('restore user')
                <th class="text-center">Actions</th>
            @endcan
        </tr>
    </thead>
    <tbody class="table-group-divider">
        @forelse ($users as $user)
            <tr class="text-center align-middle">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td style="min-width: 150px">{{ Carbon\Carbon::parse($user->deleted_at)->format('Y-m-d') }}</td>
                @can('restore user')
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">

                            <button class="btn btn-success restore-btn" data-id="{{ $user->id }}"
                                style="min-width: 50px" title="Restore"><i class="bi bi-recycle"></i></button>

                            <button class="btn btn-danger force-delete-btn" data-id="{{ $user->id }}"
                                style="min-width: 50px" title="Delete Forever"><i class="bi bi-person-dash"></i></button>

                        </div>
                    </td>
                @endcan
            </tr>
        @empty
            <tr>
                <td colspan="6" class="py-3">
                    <div class="text-center">
                        <p class="fw-boler mb-0">There is no deleted item.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
