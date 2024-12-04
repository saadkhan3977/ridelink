<!-- Example for index.blade.php -->
@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Reason List</h5>
    <div class="card-body">
<a href="{{ route('reasons.create') }}" class="btn btn-primary">Add New Reason</a><br>
<table class="table table-border">
    <thead>
        <tr>
            <th>ID</th>
            <th>Reason Text</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reasons as $reason)
            <tr>
                <td>{{ $reason->id }}</td>
                <td>{{ $reason->description }}</td>
                <td style="display: flex; gap: 5px;">
                    <a href="{{ route('reasons.edit', $reason->id) }}" class="btn btn-default">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('reasons.destroy', $reason->id) }}" onsubmit="return confirm('Are you sure you want to delete this reason?')" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
    </div>
    </div>
@endsection
