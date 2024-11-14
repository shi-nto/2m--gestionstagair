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
                    <div class="col-sm-6">
                        <h1 class="m-0 font-playwrite text-shadow">Prolongation</h1>
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
                        <form action="{{ route('proSearch') }}" method="post" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                            @csrf
                            @method('post')
                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full">
                                <select class="px-3 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 w-full sm:w-40    " id="searchCategory" name="category">
                                    <option value="numero">Numero</option>
                                    <option value="nom">Nom</option>
                                    <option value="prenom">Prénom</option>
                                    <option value="date_debut">Date début</option>
                                    <option value="date_fin">Date fin</option>
                                    <option value="old_date_fin">Ancienne Date fin</option>
                                </select>
                                <input type="text" id="usernameSearchInput" name="search" class="px-3 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 w-full sm:w-48" placeholder="Search" value="{{ old('search', $search ?? '') }}" required>
                                <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-purple-400">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('prolongation') }}" class="text-blue-500 hover:text-blue-800 mt-3 sm:mt-0 flex items-center space-x-1">
                            <i class="fas fa-sync-alt"></i> <span>Load All</span>
                        </a>
                    </div>
                </div>
                
                
                
                @if($data->isEmpty())
                <div > 
                    <p class="text-red font-bold">Aucun stagiaire prolongé n'était trouvé.</p>
                </div>
@else 
                @include('assets.success')

                <div class="table-responsive">
                    <table class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2">N°</th>
                                <th class="border border-gray-300 px-4 py-2">Nom</th>
                                <th class="border border-gray-300 px-4 py-2">Prénom</th>
                              
                                <th class="border border-gray-300 px-4 py-2">Raison</th>
                                <th class="border border-gray-300 px-4 py-2">Date de début</th>
                                <th class="border border-gray-300 px-4 py-2">Date de fin</th>
                                <th class="border border-gray-300 px-4 py-2">Durée</th>
                                <th class="border border-gray-300 px-4 py-2">Ancienne date de fin</th>
                                <th class="border border-gray-300 px-4 py-2">Département</th>
                                <th class="border border-gray-300 px-4 py-2">Ancienne département</th>
                                <th class="border border-gray-300 px-4 py-2">Encadrant</th> 
                                <th class="border border-gray-300 px-4 py-2">Ancienne encadrant</th>
                                <th class="border border-gray-300 px-4 py-2">Validé par</th> 
                                <th class="border border-gray-300 px-4 py-2">Validé par(prolongation)</th>
                                <th class="border border-gray-300 px-4 py-2">Created at</th> 
                                <th class="border border-gray-300 px-4 py-2">Prolongation</th> 
                                @if(Auth::user()->role==1)
                                <th class="border border-gray-300 px-4 py-2" colspan="2">Actions</th>
                                @endif
                            </tr>


                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $post)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->stagiaire->id }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->stagiaire->nom }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->stagiaire->prenom }}</td>
                                    @if($post->motif != null )
                                    <td class="border border-gray-300 px-4 py-2 ">{{ $post->motif }}</td>
                                    
                                    @else 
                                        <td class="border border-gray-300 px-4 py-2 font-bold text-center">-</td>
                                    @endif
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->date_debut }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->date_fin }}</td>
                                    @php
                                        $start_date = \Carbon\Carbon::parse($post->date_debut);
                                        $end_date = \Carbon\Carbon::parse($post->date_fin);
                                        $diff = $start_date->diff($end_date);
                                    @endphp

                                    <td class="border border-gray-300 px-4 py-2 @if($diff->m >= 3) text-red font-bold   @endif ">
                                        {{ $diff->m }} m  {{ $diff->d }} jrs
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->old_date_fin }}</td>
                                    @if(isset($post->encadrant))
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->encadrant->departement->nom }}</td>
                                    @else 
                                    <td class="border border-gray-300 px-4 py-2 font-bold text-center">-</td>
                                    @endif
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->old_encadrant->departement->nom }}</td>
                                    @if(isset($post->encadrant))
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->encadrant->nom ." ".$post->encadrant->prenom }}</td>
                                    @else 
                                    <td class="border border-gray-300 px-4 py-2 font-bold text-center">-</td>
                                    @endif
                                    <td class="border border-gray-300 px-4 py-2">{{ $post->old_encadrant->nom." ".$post->old_encadrant->prenom }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{  $post->old_personnel->encadrant->nom." ". $post->old_personnel->encadrant->prenom   }}</td>
                                    @if(isset($post->personnel))
                                    <td class="border border-gray-300 px-4 py-2">{{$post->personnel->encadrant->nom. " ".$post->personnel->encadrant->prenom}}</td>
                                    @else 
                                    <td class="border border-gray-300 px-4 py-2 font-bold text-center">-</td>
                                    @endif


                                    <td class="border border-gray-300 px-4 py-2">{{ $post->created_at }}</td>
                                    <td class="border border-gray-300 ">
                                        <center>
                                        <a href="/ficheProlongation/{{$post->id}}" target="_blank" class="text-red-500 hover:text-red-700" title="Fiche de prolongation">
                                            <i class="fas fa-file-alt fa-2x mx-2"></i>
                                        </a>                                           
                                    </center>    
                                    
                                    </td>
                                    @if(Auth::user()->role==1)
                                    <td class="border border-gray-300 text-center p-3">
                                    <a href="{{route('editPro',$post->id)}}" title="Editer">
                                        <i class="fas fa-edit fa-lg"></i> <!-- Edit Icon -->
                                    </a>
                                    </td>
                                    <td class="border border-gray-300 text-center p-3">
                                      
                                        <form action="{{route('pro.delete',$post->id)}}" method="POST" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit " > <img src="{{ asset('storage/images/bin.png') }}" alt="delete Icon" class="w-6 h-6 inline" title="Supprimer"></button>
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
