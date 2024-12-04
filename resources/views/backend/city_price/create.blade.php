@extends('backend.layouts.master')
@section('main-content')
<div class="card">
    <h5 class="card-header">Add City Price</h5>
    <div class="card-body">
    <form action="{{ route('city_price.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>City From:</label>
            <input type="text" name="city_from" class="form-control" required>
            @error('city_from')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>City To:</label>
            <input type="text" name="city_to" class="form-control"  required>
            @error('city_to')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" class="form-control"  required>
            @error('price')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <button  class="btn btn-primary" type="submit">Add</button>
        </div>
    </form>
@endsection
