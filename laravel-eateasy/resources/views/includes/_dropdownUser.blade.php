{{-- Dropdown Structure nel TopNav --}}
@if (Auth::guest())
    <!-- Nessun utente loggato -->
    <ul id="dropdownUserTopNav" class="dropdown-content">
        <li><a href="{{ url('/login') }}">Login</a></li>
        <li><a href="{{ url('/register') }}">Registrati</a></li>
    </ul>
@else
    <!-- Utente loggato -->
    <ul id="dropdownUserTopNav" class="dropdown-content">
        <li><a href="{{ url('/logout') }}">Logout</a></li>
        <li class="divider"></li>
        <li><a href="{{ url('/reservedarea') }}">Area riservata</a></li>
    </ul>
@endif

{{-- Dropdown Structure nel SideNav --}}
@if (Auth::guest())
    <!-- Nessun utente loggato -->
    <ul id="dropdownUserSideNav" class="dropdown-content">
        <li><a href="{{ url('/login') }}">Login</a></li>
        <li><a href="{{ url('/register') }}">Registrati</a></li>
    </ul>
@else
    <!-- Utente loggato -->
    <ul id="dropdownUserSideNav" class="dropdown-content">
        <li><a href="{{ url('/logout') }}">Logout</a></li>
        <li class="divider"></li>
        <li><a href="{{ url('/reservedarea') }}">Area riservata</a></li>
    </ul>
@endif