<link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{asset('css/bootstrap4.min.css')}}">
<link href="{{asset('css/tailwind.css')}}" rel="stylesheet">

<aside id="mainSidebar" class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a  class="brand-link flex items-center justify-center">
        <img src="{{ asset('storage/images/2M_logo.png') }}" alt="logo" width="130" height="32" class="py-3">
    </a>



    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a  class="d-block"><b><i>Dashboard</i></b></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="dashboard" class="nav-link active">
                        <i class="nav-icon fas fa-file-alt fa-2x "></i>
                        <p>Fiches<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route("fiche.initiale")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fiche de stage</p>
                            </a>
                            <a href="{{route('fiche.attestation')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Attestations de stage</p>
                            </a>
                            
                            <a href="{{route("fiche.prolongations")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Prolongations</p>
                            </a>
                           
                            
                        </li>
                    </ul>
                </li>

                @if(Auth::user()->role==1) 
                <li class="nav-item">
                    <a href="users" class="nav-link active">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Departements<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                         
                            <a href="{{route('admin','addDepForm')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                            <a href="/admin/departement" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lister</p>
                            </a>
                            <a href="/admin/deletedDep" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supprimé</p>
                            </a>
                          
                           
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="users" class="nav-link active">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Encadrants<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">

                            <a href="{{route('admin','addEncForm')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>

                            <a href="/admin/encadrant" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lister</p>
                            </a>
                            <a href="/admin/deletedEnc" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supprimé</p>
                            </a>
                           
                         
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="users" class="nav-link active">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilisateurs<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            
                            <a href="{{route('admin','addUserForm')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>

                            <a href="/admin/users" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lister</p>
                            </a>
                           
                          
                        </li>
                    </ul>
                </li>
                
                @endif
                <!-- Posts -->
                <li class="nav-item">
                    <a href="dashboard" class="nav-link active">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Stagiaire<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('addInternForm')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ajouter</p>
                            </a>
                            <a href="{{route("prolongation")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>prolongation</p>
                            </a>
                            <a href="{{route("home")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lister</p>
                            </a>
                           
                            
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="dashboard" class="nav-link active">
                        <i class="nav-icon left fas fa-chart-pie"></i>
                        <p>Statistiques<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route("statistics.index")}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lister</p>
                            </a>
                        </li>
                    </ul>
                </li>
            
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables JS -->
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<script>
    document.addEventListener   ('DOMContentLoaded', function() {
        // Function to hide sidebar
        function hideSidebar() {
            if (document.body.classList.contains('sidebar-open')) {
                document.body.classList.remove('sidebar-open');
                document.body.classList.add('sidebar-collapse');
            }
        }
        
        // Listen for click events on the body
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('mainSidebar');
            const menuButton = document.querySelector('[data-widget="pushmenu"]');

            // If the click is outside the sidebar and not on the menu button
            if (!sidebar.contains(event.target) && !menuButton.contains(event.target)) {
                hideSidebar();
            }
        });
    }); 
</script>