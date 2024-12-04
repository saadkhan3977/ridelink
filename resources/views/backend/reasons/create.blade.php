<!-- resources/views/admin/reasons/create.blade.php -->
@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Add New Reason</h5>
    <div class="card-body">
{{-- <h1></h1> --}}

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('reasons.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="description">Reason Text</label>
        <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Reason</button>
    <a href="{{ route('reasons.index') }}" class="btn btn-secondary">Cancel</a>
</form>
    </div>
    </div>
@endsection
