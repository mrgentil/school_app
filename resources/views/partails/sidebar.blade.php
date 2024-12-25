<div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
    <div class="mobile-sidebar-header d-md-none">
        <div class="header-logo">
            <a href="{{url('/')}}"><img src="{{asset('img/logo1.png')}}" alt="logo"></a>
        </div>
    </div>
    <div class="sidebar-menu-content">
        <ul class="nav nav-sidebar-menu sidebar-toggle-view">
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i class="flaticon-multiple-users-silhouette"></i><span>Utilisateur</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('users.create')}}" class="nav-link"><i class="fas fa-angle-right"></i>Ajouter
                            utilisateur</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link"><i
                                class="fas fa-angle-right"></i>Les utilisateurs</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i class="flaticon-settings-work-tool"></i><span>Roles</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('roles.create')}}" class="nav-link"><i class="fas fa-angle-right"></i>Ajouter
                            roles</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('roles.index')}}" class="nav-link"><i
                                class="fas fa-angle-right"></i>Les roles</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i class="flaticon-books"></i><span>Ecole</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('schools.create')}}" class="nav-link"><i class="fas fa-angle-right"></i>Ajouter
                            école</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('schools.index')}}" class="nav-link"><i
                                class="fas fa-angle-right"></i>Les écoles</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Eleves</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('students.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>Les Eleves</a>
                    </li>
                    <li class="nav-item">
                        <a href="student-details.html" class="nav-link"><i
                                class="fas fa-angle-right"></i>Student Details</a>
                    </li>
                    <li class="nav-item">
                        <a href="admit-form.html" class="nav-link"><i
                                class="fas fa-angle-right"></i>Admission Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="student-promotion.html" class="nav-link"><i
                                class="fas fa-angle-right"></i>Student Promotion</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
