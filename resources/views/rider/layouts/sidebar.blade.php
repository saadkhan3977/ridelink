<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route( 'rider.dashboard' ) }}">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Rider</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{ route( 'rider.dashboard' ) }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    {{-- Cars --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fas fa-cubes"></i>
          <span>Cars</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Product Options:</h6>
            <a class="collapse-item" href=" {{ route('rider-car.index') }}">View</a>
            <a class="collapse-item" href="{{route('rider-car.create')}}">Add </a>
          </div>
        </div>
    </li>

    @if(Auth::user()->role == 'admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rideCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fas fa-cubes"></i>
          <span>Rides</span>
        </a>
        <div id="rideCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options</h6>
            <a class="collapse-item" href=" {{ 'car-ride-new' }}">New Request </a>
            <a class="collapse-item" href="{{ 'car-rides' }}">Rides List</a>
          </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tCollapse" aria-expanded="true" aria-controls="tCollapse">
          <i class="fas fa-cubes"></i>
          <span>Prices</span>
        </a>
        <div id="tCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options</h6>
            <a class="collapse-item" href=" {{ route('city_price.index') }}">View </a>
            <a class="collapse-item" href="{{ route('city_price.create') }}">Add</a>
          </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reasons" aria-expanded="true" aria-controls="tCollapse">
          <i class="fas fa-cubes"></i>
          <span>Reasons</span>
        </a>
        <div id="reasons" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Options</h6>
            <a class="collapse-item" href=" {{ route('reasons.index') }}">View </a>
            <a class="collapse-item" href="{{ route('reasons.create') }}">Add</a>
          </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->




     <!-- Users -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-users"></i>
            <span>Users </span></a>
    </li>

     <!-- General settings -->
     <li class="nav-item">
        <a class="nav-link" href="{{route('settings')}}">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

  @endif









    <!-- Divider -->


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
