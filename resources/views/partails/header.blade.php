<div class="navbar navbar-expand-md header-menu-one bg-light">
    <div class="nav-bar-header-one">
        <div class="header-logo">
            <a href="{{url('/')}}">
                <img src="{{asset('img/logo.png')}}" alt="logo">
            </a>
        </div>
        <div class="toggle-button sidebar-toggle">
            <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
            </button>
        </div>
    </div>
    <div class="d-md-none mobile-nav-bar">
        <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
                data-target="#mobile-navbar" aria-expanded="false">
            <i class="far fa-arrow-alt-circle-down"></i>
        </button>
        <button type="button" class="navbar-toggler sidebar-toggle-mobile">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
        <ul class="navbar-nav">
            <li class="navbar-item header-search-bar">
                <div class="input-group stylish-input-group">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="flaticon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                    <input type="text" class="form-control" placeholder="Trouver quelque chose . . .">
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="navbar-item dropdown header-admin">
                @if(auth()->check())
                <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                    <div class="admin-title">
                        <h5 class="item-title">{{ auth()->user()->first_name }}</h5>
                        <span>{{ auth()->user()->role->name ?? 'Rôle non défini' }}</span>
                    </div>
                    <div class="admin-img">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="img-thumbnail rounded-circle" style="width: 50px; height: 50px;">
                        @else
                            @php
                                $initials = strtoupper(substr(auth()->user()->name, 0, 1)) . strtoupper(substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1));
                                $colors = ['#FF5733', '#33FF57', '#3357FF', '#F333FF', '#FFAF33'];
                                $bgColor = $colors[array_rand($colors)];
                            @endphp
                            <div class="generated-avatar" style="background-color: {{ $bgColor }};">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="item-header">
                        <h6 class="item-title">{{ auth()->user()->first_name }} - {{ auth()->user()->name }}</h6>
                    </div>
                    <div class="item-content">
                        <ul class="settings-list">
                            <li><a href="#"><i class="flaticon-user"></i>Mon Profil</a></li>
                            <li><a href="#"><i class="flaticon-gear-loading"></i>Parametres</a></li>
                            <li>
                                <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="flaticon-turn-off"></i>Deconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li class="navbar-item dropdown header-message">
                <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-expanded="false">
                    <i class="far fa-envelope"></i>
                    <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                    <span>5</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="item-header">
                        <h6 class="item-title">05 Message</h6>
                    </div>
                    <div class="item-content">
                        <div class="media">
                            <div class="item-img bg-skyblue author-online">
                                <img src="img/figure/student11.png" alt="img">
                            </div>
                            <div class="media-body space-sm">
                                <div class="item-title">
                                    <a href="#">
                                        <span class="item-name">Maria Zaman</span>
                                        <span class="item-time">18:30</span>
                                    </a>
                                </div>
                                <p>What is the reason of buy this item.
                                    Is it usefull for me.....</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="item-img bg-yellow author-online">
                                <img src="img/figure/student12.png" alt="img">
                            </div>
                            <div class="media-body space-sm">
                                <div class="item-title">
                                    <a href="#">
                                        <span class="item-name">Benny Roy</span>
                                        <span class="item-time">10:35</span>
                                    </a>
                                </div>
                                <p>What is the reason of buy this item.
                                    Is it usefull for me.....</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="item-img bg-pink">
                                <img src="img/figure/student13.png" alt="img">
                            </div>
                            <div class="media-body space-sm">
                                <div class="item-title">
                                    <a href="#">
                                        <span class="item-name">Steven</span>
                                        <span class="item-time">02:35</span>
                                    </a>
                                </div>
                                <p>What is the reason of buy this item.
                                    Is it usefull for me.....</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="item-img bg-violet-blue">
                                <img src="img/figure/student11.png" alt="img">
                            </div>
                            <div class="media-body space-sm">
                                <div class="item-title">
                                    <a href="#">
                                        <span class="item-name">Joshep Joe</span>
                                        <span class="item-time">12:35</span>
                                    </a>
                                </div>
                                <p>What is the reason of buy this item.
                                    Is it usefull for me.....</p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navbar-item dropdown header-notification">
                <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                   aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                    <span>8</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="item-header">
                        <h6 class="item-title">03 Notifiacations</h6>
                    </div>
                    <div class="item-content">
                        <div class="media">
                            <div class="item-icon bg-skyblue">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="media-body space-sm">
                                <div class="post-title">Complete Today Task</div>
                                <span>1 Mins ago</span>
                            </div>
                        </div>
                        <div class="media">
                            <div class="item-icon bg-orange">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="media-body space-sm">
                                <div class="post-title">Director Metting</div>
                                <span>20 Mins ago</span>
                            </div>
                        </div>
                        <div class="media">
                            <div class="item-icon bg-violet-blue">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="media-body space-sm">
                                <div class="post-title">Update Password</div>
                                <span>45 Mins ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="navbar-item dropdown header-language">
                <a class="navbar-nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-expanded="false"><i class="fas fa-globe-americas"></i>EN</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">English</a>
                    <a class="dropdown-item" href="#">Spanish</a>
                    <a class="dropdown-item" href="#">Franchis</a>
                    <a class="dropdown-item" href="#">Chiness</a>
                </div>
                @else
                    <a class="navbar-nav-link" href="{{ route('login') }}">
                        <div class="admin-title">
                            <h5 class="item-title">Connectez-vous</h5>
                        </div>
                    </a>
                @endif
            </li>
        </ul>
    </div>
</div>
