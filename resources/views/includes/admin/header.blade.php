 <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Sign Booking</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="{{ Request::is('admin') ? 'active' : '' }}"><a href="/admin">Home</a></li>
                    <li class="{{ Request::is('admin/users*') ? 'active' : '' }}"><a href="/admin/users">Admin Users</a></li>
                    <li class="{{ Request::is('admin/assets*') ? 'active' : '' }}"><a href="/admin/assets">Assets</a></li>
                    <li class="{{ Request::is('admin/bookings*') ? 'active' : '' }}"><a href="/admin/bookings">Bookings</a></li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>