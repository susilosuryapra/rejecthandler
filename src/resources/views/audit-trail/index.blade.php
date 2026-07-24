@extends('adminlte::page')
@section('plugins.Datatables', true)

@section('title', 'Audit Trail')

@section('content_header')
    <h1>Audit Trail</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body" style="overflow-x: auto;">
            <table id="audit-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee Name</th>
                        <th>Action</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $activities = \Spatie\Activitylog\Models\Activity::with('causer')
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp
                    @foreach($activities as $index => $activity)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $activity->causer->name ?? '-' }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
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
        $('#audit-table').DataTable({
            order: [[3, 'desc']]
        });
    });
</script>
@endsection