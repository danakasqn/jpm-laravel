<ul class="nav flex-column gap-2">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}"
           class="nav-link px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            🏠 Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('finanse.index') }}"
           class="nav-link px-3 py-2 rounded {{ request()->routeIs('finanse.index') ? 'active' : '' }}">
            💰 Finanse
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('mieszkania.index') }}"
           class="nav-link px-3 py-2 rounded {{ request()->routeIs('mieszkania.*') ? 'active' : '' }}">
            🏢 Lokale
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('residents.index') }}"
           class="nav-link px-3 py-2 rounded {{ request()->routeIs('residents.*') ? 'active' : '' }}">
            👤 Najemcy
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cyclic-finances.index') }}"
           class="nav-link px-3 py-2 rounded {{ request()->routeIs('cyclic-finances.*') ? 'active' : '' }}">
            🔁 Cykliczne
        </a>
    </li>
    <li class="nav-item mt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-light w-100 d-flex align-items-center justify-center gap-2">
                🚪 Wyloguj
            </button>
        </form>
    </li>
</ul>
