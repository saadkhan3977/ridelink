@extends('backend.layouts.master')
@section('main-content')
<div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Lists</h6>
      <a href="{{route('city_price.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add </a>
    </div>
    <div class="card-body">
      <div class="table-responsive">

        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>City From</th>
                    <th>City To</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php 
                $id =1;
                @endphp
                @foreach($CityPrices as $ride)
                <tr>
                    <td>{{ $id++ }}</td>
                    <td>{{ $ride->city_from }}</td>
                    <td>{{ $ride->city_to }}</td>
                    <td>{{ $ride->price }}</td>
                    <td>
                        <a href="{{ route('city_price.edit', $ride->id) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('city_price.destroy', $ride->id) }}" onsubmit="return confirm('Are You Sure Want to delete this..??')" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
</div>
</div>
@endsection
