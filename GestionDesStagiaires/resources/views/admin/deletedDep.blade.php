@include('assets.headerAdmin')

<body class="hold-transition sidebar-mini layout-fixed">
    @include('assets.navbarAdmin')
    @include('assets.sidebarAdmin')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 font-playwrite">Départments</h1>
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
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-3">
                       
                    </div>
                </div>
                
                @if($data->isEmpty())
                    <div > 
                        <p class="text-red font-bold">Aucun département n'était trouvé.</p>
                    </div>
@else 
                @include('assets.success')
           
                <div class="table-responsive">
                    <table class="table-auto  w-full border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 w-1/2 px-4 py-2 text-center">Nom</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($data as $item)
                        
                                <tr>
                                    
                                    <td class="border border-gray-300 w1/2 px-4 py-2">{{ $item->nom }}</td>
                                    <td class="border border-gray-300 w-1/6  text-center px-4 py-2">
                                      <a href="/admin/depRestore/{{$item->id}}" onclick="deletedConfirm()"> <i class="fas fa-undo-alt fa-lg"></i>
                                      </a>
                                        </form>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                    <div class="flex justify-center mt-3">
                        {{ $data->appends(['search' => request()->input('search')])->links() }}
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
    <script>
        function deletedConfirm() {
        return confirm("Êtes-vous sûr de vouloir restaurer ce département ?");
    }
    </script>
    <!-- Additional scripts or JavaScript if required -->

</body>
