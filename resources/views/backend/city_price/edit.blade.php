@extends('backend.layouts.master')
@section('main-content')
<div class="card">
    <h5 class="card-header">Edit City Price</h5>
    <div class="card-body">
    <form action="{{ route('city_price.update', $CityPrice->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>City From:</label>
            <input type="text" name="city_from" class="form-control" value="{{ $CityPrice->city_from }}" required>
            @error('city_from')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>City To:</label>
            <input type="text" name="city_to" class="form-control" value="{{ $CityPrice->city_to }}" required>
            @error('city_to')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" class="form-control" value="{{ $CityPrice->price }}"  required>
            @error('price')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <button  class="btn btn-primary" type="submit">Update Ride</button>
        </div>
    </form>
@endsection
