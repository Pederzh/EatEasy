@include('includes._dropdownUser')

<!-- NAVBAR -->
<!-- navbar fissata per tutta la pagina -->
<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper">
            <a href="{{ url('/') }}" class="logo">EATEASY</a>
            <!-- carica il sideNav sugli schermi med-and-down -->
            <a href="#" data-activates="sideNav" class="button-collapse"><i class="material-icons">menu</i></a>

                <!-- TOP NAV -->
                <ul id="topNav" class="right hide-on-med-and-down">
                    <li><a href="{{ url('/ricerca') }}">Ricerca</a></li>
                    <li><a href="{{ url('/chisiamo') }}">Chi siamo</a></li>
                    <li><a href="{{ url('/contatti') }}">Contatti</a></li>
                    <!-- fa riferimento alla struttura dropdown precedentemente dichiarata -->
                    <li><a id="dropdownTopNav" class="dropdown-button" data-activates="dropdownUserTopNav">
                        @if (Auth::guest())
                            Area Riservata
                        @else
                            {{ Auth::user()->email }}
                        @endif
                        <i class="material-icons right">arrow_drop_down</i></a>
                    </li>
                </ul>
                <!-- END TOP NAV -->

                <!-- SIDE NAV visualizzata sui mobile -->
                <ul id="sideNav" class="side-nav">
                    <li><a href="{{ url('/ricerca') }}">Ricerca</a></li>
                    <li><a href="{{ url('/chisiamo') }}">Chi siamo</a></li>
                    <li><a href="{{ url('/contatti') }}">Contatti</a></li>
                    <!-- fa riferimento alla struttura dropdown precedentemente dichiarata -->
                    <li><a id="dropdownSideNav" class="dropdown-button" data-activates="dropdownUserSideNav">
                        @if (Auth::guest())
                            Area Riservata
                        @else
                            {{ Auth::user()->email }}
                        @endif
                        <i class="material-icons right">arrow_drop_down</i></a>
                    </li>
                </ul>
                <!-- END SIDE NAV visualizzata sui mobile -->
        </div>
    </nav>
</div>
<!-- NAVBAR END -->