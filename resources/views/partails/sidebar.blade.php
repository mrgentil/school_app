<div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
    <div class="mobile-sidebar-header d-md-none">
        <div class="header-logo">
            <a href="{{url('/')}}"><img src="{{asset('img/logo1.png')}}" alt="logo"></a>
        </div>
    </div>
    <div class="sidebar-menu-content">
        <ul class="nav nav-sidebar-menu sidebar-toggle-view">
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
                <a href="#" class="nav-link"><i class="flaticon-books"></i><span>Ecoles</span></a>
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
                <a href="#" class="nav-link"><i class="flaticon-multiple-users-silhouette"></i><span>Utilisateurs</span></a>
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
                <a href="#" class="nav-link"><i class="flaticon-settings-work-tool"></i><span>Options</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('options.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>Les
                            Options</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('options.create')}}" class="nav-link"><i
                                class="fas fa-angle-right"></i>Ajouter Option</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i
                        class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler"></i><span>Classes</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('classes.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>Les
                            Classes</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('classes.create')}}" class="nav-link"><i
                                class="fas fa-angle-right"></i>Ajouter Classe</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i class="flaticon-technological"></i><span>Promotions</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('promotions.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>Les
                            Promotions</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('promotions.create')}}" class="nav-link"><i
                                class="fas fa-angle-right"></i>Ajouter Promotion</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Eleves</span></a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('students.index')}}" class="nav-link"><i class="fas fa-angle-right"></i>Admission
                            Eleve</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('histories.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Historique Eleve
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student-promotions.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Promotion des élèves
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link">
                    <i class="flaticon-books"></i>
                    <span>Matières</span>
                </a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Liste des matières
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subjects.create') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Ajouter matière
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link">
                    <i class="flaticon-multiple-users-silhouette"></i>
                    <span>Professeurs</span>
                </a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{ route('teachers.assigned') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Liste des professeurs assigner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teachers.assign-form') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Assigner une matière
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('workload.overview') }}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Suivi de la charge de travail des enseignants
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item sidebar-nav-item">
                <a href="#" class="nav-link">
                    <i class="flaticon-multiple-users-silhouette"></i>
                    <span>Programmes Scolaire</span>
                </a>
                <ul class="nav sub-group-menu">
                    <li class="nav-item">
                        <a href="{{route('programmes.create')}}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Importer un programme
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('programmes.index')}}" class="nav-link">
                            <i class="fas fa-angle-right"></i>Voir Programmes
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
