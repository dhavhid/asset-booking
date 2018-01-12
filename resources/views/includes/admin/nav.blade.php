<nav class="navbar navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('admin') ? 'active' : '' }}"><a href="{{ url('/admin') }}">Home</a></li>
                <li class="{{ Request::is('admin/users*') ? 'active' : '' }}"><a href="{{ url('/admin/users') }}">Admin Users</a></li>
                <li class="{{ Request::is('admin/asset*') ? 'active' : '' }}"><a href="{{ url('/admin/assets') }}">Assets</a></li>
                <li class="{{ Request::is('admin/categor*') ? 'active' : '' }}"><a href="{{ url('/admin/categories') }}">Asset Categories</a></li>
                <li class="dropdown {{ Request::is('admin/locations*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Locations <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/admin/locations/buildings') }}">Buildings</a></li>
                        <li><a href="{{ url('/admin/locations/regions') }}">Regions</a></li>
                    </ul>
                </li>
                <li class="{{ Request::is('admin/specification*') ? 'active' : '' }}"><a href="{{ url('/admin/specifications') }}">Specifications</a></li>
                <li class="{{ Request::is('admin/bookings*') ? 'active' : '' }}"><a href="{{ url('/admin/bookings') }}">Bookings</a></li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>