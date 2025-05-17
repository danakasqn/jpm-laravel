<nav class="d-flex flex-column gap-2">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('finanse.index') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('finanse.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin me-2"></i>
                <span>Finanse</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('mieszkania.index') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('mieszkania.*') ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i>
                <span>Lokale</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('residents.index') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('residents.*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard me-2"></i>
                <span>Najemcy</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('cyclic-finances.index') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('cyclic-finances.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-repeat me-2"></i>
                <span>Cykliczne</span>
            </a>
        </li>

    </ul>
</nav>
