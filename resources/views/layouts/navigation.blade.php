<style>
    .badge-sm {
        font-size: 0.75rem;
        padding: 0.35em 0.6em;
    }
</style>

<nav id="sidebar" class="d-flex flex-column gap-2 flex-grow-1" role="navigation">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Finanse --}}
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center justify-content-between"
               data-bs-toggle="collapse" href="#submenu-finanse" role="button"
               aria-expanded="{{ request()->is('finanse*') ? 'true' : 'false' }}"
               aria-controls="submenu-finanse">
                <div class="d-flex align-items-center">
                    <i class="bi bi-cash-coin me-2"></i>
                    Finanse
                </div>
                @if(isset($pendingCount) && $pendingCount > 0)
                    <span class="badge bg-danger ms-2 badge-sm">{{ $pendingCount }}</span>
                @endif
            </a>
            <div class="collapse {{ request()->is('finanse*') ? 'show' : '' }}" id="submenu-finanse">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a href="{{ route('finanse.formularz') }}"
                           class="nav-link {{ request()->routeIs('finanse.formularz') ? 'active' : '' }}">
                            Formularz finansów
                        </a>
                    </li>
                    <li class="nav-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('finanse.operacje') }}"
                           class="nav-link {{ request()->routeIs('finanse.operacje') ? 'active' : '' }}">
                            Operacje do wykonania
                        </a>
                        @if(isset($pendingCount) && $pendingCount > 0)
                            <span class="badge bg-danger ms-2 me-2 badge-sm">{{ $pendingCount }}</span>
                        @endif
                    </li>
                </ul>
            </div>
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
