@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Ride Assign</h6>
    </div>
    <div class="card-body">
        <form method="post" action="{{route('ride-assign',$ride->id)}}">
            {{csrf_field()}}
            <!-- <div class="form-group">
                <label for="status" class="col-form-label">Car <span class="text-danger">*</span></label>
                <select name="car_id" required class="form-control">
                    <option value="">::select car::</option>
                    @foreach($cars as $car)
                        <option value="{{$car->id}}">{{$car->name}} - {{$car->no}}</option>
                    @endforeach
                </select>
                @error('car_id')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div> -->
            
            <div class="form-group">
                <label for="status" class="col-form-label">Riders <span class="text-danger">*</span></label>
                <select name="rider_id" required class="form-control">
                    <option value="">::select rider::</option>
                    @foreach($riders as $rider)
                        <option value="{{$rider->id}}">{{$rider->name}}</option>
                    @endforeach
                </select>
                @error('rider')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <!-- <button type="reset" class="btn btn-warning">Reset</button> -->
                <button class="btn btn-success" type="submit">Assign</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#product-dataTable').DataTable( {
        "scrollX": false
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[10,11,12]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
