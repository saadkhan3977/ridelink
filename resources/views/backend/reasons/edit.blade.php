<!-- resources/views/admin/reasons/edit.blade.php -->
@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Edit Reason</h5>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reasons.update', $reason->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="description">Reason Text</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $reason->description) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Reason</button>
            <a href="{{ route('reasons.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
