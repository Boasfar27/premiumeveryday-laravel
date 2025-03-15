@extends('pages.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Users Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Users List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Verified</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 1 ? 'primary' : 'secondary' }}">
                                            {{ $user->role == 1 ? 'Admin' : 'User' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @if ($user->id !== Auth::id())
                                                <form action="{{ route('admin.users.delete', $user) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable({
                    order: [
                        [0, 'desc']
                    ],
                    pageLength: 10,
                });
            });
        </script>
    @endpush
@endsection
