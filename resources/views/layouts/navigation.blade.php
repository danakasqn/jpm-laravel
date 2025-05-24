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

        {{-- Cykliczne --}}
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center justify-content-between"
               data-bs-toggle="collapse" href="#submenu-cykliczne" role="button"
               aria-expanded="{{ request()->is('cyclic-finances*') ? 'true' : 'false' }}"
               aria-controls="submenu-cykliczne">
                <div class="d-flex align-items-center">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    Cykliczne
                </div>
            </a>
            <div class="collapse {{ request()->is('cyclic-finances*') ? 'show' : '' }}" id="submenu-cykliczne">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a href="{{ route('cyclic-finances.index') }}"
                           class="nav-link {{ request()->routeIs('cyclic-finances.index') ? 'active' : '' }}">
                            Lista cyklicznych
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cyclic-finances.urzad-skarbowy') }}"
                           class="nav-link {{ request()->routeIs('cyclic-finances.urzad-skarbowy') ? 'active' : '' }}">
                            Urząd Skarbowy
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        {{-- 🔧 Ustawienia --}}
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center justify-content-between"
               data-bs-toggle="collapse" href="#submenu-ustawienia" role="button"
               aria-expanded="{{ request()->is('ustawienia*') ? 'true' : 'false' }}"
               aria-controls="submenu-ustawienia">
                <div class="d-flex align-items-center">
                    <i class="bi bi-gear-fill me-2"></i>
                    Ustawienia
                </div>
            </a>
            <div class="collapse {{ request()->is('ustawienia*') ? 'show' : '' }}" id="submenu-ustawienia">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a href="{{ route('settings.expense-types.index') }}"
                           class="nav-link {{ request()->routeIs('settings.expense-types.*') ? 'active' : '' }}">
                            Typy wydatków
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
