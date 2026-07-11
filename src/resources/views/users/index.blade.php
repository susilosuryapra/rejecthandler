@extends('adminlte::page')
@section('plugins.Datatables', true)

@section('title', 'Management User')

@section('content_header')
    <h1>Management User</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.create') }}" class="btn btn-primary float-right">
                <i class="fas fa-plus"></i> Create
            </a>
        </div>
        <div class="card-body">
            <table id="users-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Employee Role</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\User::all() as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->uuid) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#users-table').DataTable();
    });
</script>
@endsection