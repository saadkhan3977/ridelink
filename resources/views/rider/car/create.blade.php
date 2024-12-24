@extends('rider.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Car</h5>
    <div class="card-body">
      <form method="post" action="{{route('rider-car.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <!-- <input  type="text" name="user_id" value="{{auth()->user()->id}}" hidden> -->
          <input id="inputTitle" type="text" name="name" placeholder="Enter title"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Model <span class="text-danger">*</span></label>
          <!-- <input  type="text" name="user_id" value="{{auth()->user()->id}}" hidden> -->
          <input id="inputTitle" type="number" name="model" placeholder="Enter model"  value="{{old('model')}}" class="form-control">
          @error('model')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Car No <span class="text-danger">*</span></label>
          <input id="car-no" type="text" name="no" placeholder="ABC-123"  value="{{old('no')}}" class="form-control">

          <span id="error" class="text-danger">@error('no'){{$message}}@enderror</span>

        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Seats <span class="text-danger">*</span></label>
          <!-- <input  type="text" name="user_id" value="{{auth()->user()->id}}" hidden> -->
          <input id="inputTitle" type="number" name="seats" placeholder="Enter Seats"  value="{{old('seats')}}" class="form-control">
          @error('seats')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="status" class="col-form-label">Category <span class="text-danger">*</span></label>
            <select name="type" class="form-control">
                <option value="Mini">Mini</option>
                <option value="Standard Ac">Standard Ac</option>
                <option value="Luxury Ac">Luxury Ac</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>


        {{-- <div class="form-group">
          <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Enter price" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}


        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="image" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>



        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>

    $('#lfm').filemanager('image');

</script>
<script>
  document.getElementById('car-no').addEventListener('input', function () {
    let value = this.value;
    const regex = /^[A-Za-z]{3}-\d{3}$/; // Valid format: 3 letters, a hyphen, and 3 digits
    const errorSpan = document.getElementById('error');

    // Dynamically clean input
    value = value
        .replace(/[^A-Za-z0-9-]/g, '') // Remove invalid characters
        .replace(/^([^A-Za-z]*)/, '') // Remove numbers or invalid characters at the start
        .replace(/([A-Za-z]{3})[^-]?/, '$1-') // Ensure the hyphen comes after 3 letters
        .replace(/(\d{3}).*/, '$1') // Ensure only 3 digits after the hyphen
        .slice(0, 7); // Limit to 7 characters (ABC-123)

    this.value = value; // Update input value dynamically

    // Validate against regex
    if (!regex.test(value)) {
        errorSpan.textContent = "Invalid format. Use 3 letters, a hyphen, and 3 digits (e.g., ABC-123).";
    } else {
        errorSpan.textContent = ""; // Clear error message
    }
});

    </script>
<script>

  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
@endpush
