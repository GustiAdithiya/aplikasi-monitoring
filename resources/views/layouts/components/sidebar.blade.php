<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Route::current()->getName()=='home' ? '' : 'collapsed' }}" href="{{route('home')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if(auth()->user()->role == "admin")
        <li class="nav-item">
            <a class="nav-link {{ Route::current()->getName()=='admin.instance.index' ? '' : 'collapsed' }}" href="{{ route('admin.instance.index') }}">
                <i class="bi bi-person"></i>
                <span>Penyelenggara</span>
            </a>
        </li>
        @else
        <li class="nav-item">
            <a class="nav-link {{ Route::current()->getName()=='instance.package.index' ? '' : 'collapsed' }}" href="{{ route('instance.package.index') }}">
                <i class="bi bi-person"></i>
                <span>Paket Ujian</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::current()->getName()=='instance.monitoring.package' ? '' : 'collapsed' }}" href="{{ route('instance.monitoring.package') }}">
                <i class="bi bi-display"></i>
                <span>Monitoring</span>
            </a>
        </li>
        @endif
    </ul>
</aside>