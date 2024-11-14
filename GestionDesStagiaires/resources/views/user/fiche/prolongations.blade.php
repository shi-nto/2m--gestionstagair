<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.headerAdmin')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2M</title>
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @include('assets.navbarAdmin')
    @include('assets.sidebarAdmin')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 ">
                        <h1 class="m-0 flex font-playwrite text-shadow">Fiches de prolongations</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <!-- Additional content header if needed -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        
        <section class="content py-4">
            <div class="container mx-auto px-4">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                        <form action="{{route('fiche.searchP')}}" method="post" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                            @csrf
                            @method('post')
                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full">
                                <select class="px-3 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 w-full sm:w-40    " id="searchCategory" name="category">
                                    <option value="numero">Numero</option>
                                    <option value="nom">Nom</option>
                                    <option value="prenom">Prénom</option>
                                    <option value="date_debut">Année</option>
                                    <option value="date_fin">Mois</option>
                                </select>
                                <input type="text" id="usernameSearchInput" name="search" class="px-3 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 w-full sm:w-48" placeholder="Search" value="{{ old('search', $search ?? '') }}" required>
                                <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-purple-400">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('fiche.prolongations') }}" class="text-blue-500 hover:text-blue-800 mt-3 sm:mt-0 flex items-center space-x-1">
                            <i class="fas fa-sync-alt"></i> <span>Load All</span>
                        </a>
                    </div>
                </div>
                
                
                @if($data->isEmpty())
                <div > 
                    <p class="text-red font-bold">Aucune fiche de prolongation n'était trouvé.</p>
                </div>
@else 

                @include('assets.success')

                <div class="table-responsive">
                    <table class="table-auto w-full border-collapse border border-gray-200 ">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2">N°</th>                                
                                <th class="border border-gray-300 px-4 py-2">Nom complét</th>
                                <th class="border border-gray-300 px-4 py-2">Mois</th>
                                <th class="border border-gray-300 px-4 py-2">Année</th>
                               
                                @if(auth()->user()->role == 1)
                                <th class="border border-gray-300 px-4 py-2" colspan="4">Actions</th>
                                @endif
                                

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $post)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->nombre }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->nom}}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->mois }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->annee }}</td>
                                    
                                    @if(Auth::user()->role==1)
                                    <td class="border border-gray-300 p-4">
                                        <form action="{{route('fiche.delete',$post->id)}}" method="POST" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-transparent border-none mx-2" title="Supprimer">
                                                <i class="fas fa-trash fa-lg"></i>     
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                    
                                  
                                    
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="flex justify-center mt-3">
                        {{ $data->appends(['search' => request()->input('search')])->links() }}
                    </div>
                </div>
                @endif
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</body>
</html>
