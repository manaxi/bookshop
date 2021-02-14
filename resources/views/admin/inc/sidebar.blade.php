<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.index')}}" class="brand-link">
        <span class="brand-text font-weight-light">Bookshop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}} {{Auth::user()->surname}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li><a href="{{route('admin.books.index')}}"
                       class="nav-link {{ (request()-> routeIs('admin.books*')) ? 'active ' : '' }}"><i
                            class="fa fa-book"></i> <span>Books</span></a></li>
                <li><a href="{{route('admin.authors.index')}}"
                       class="nav-link {{ (request()-> routeIs('admin.authors*')) ? 'active ' : '' }}"><i
                            class="fa fa-users"></i> <span>Authors</span></a></li>
                <li><a href="{{route('admin.genres.index')}}"
                       class="nav-link {{ (request()-> routeIs('admin.genres*')) ? 'active ' : '' }}"><i
                            class="fa fa-folder"></i> <span>Genres</span></a></li>
                <li><a href="{{route('admin.reports.index')}}"
                       class="nav-link {{ (request()-> routeIs('admin.reports*')) ? 'active ' : '' }}"><i
                            class="fa fa-folder"></i> <span>Reports</span></a></li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
