@include('assets.headerAdmin')

<body class="hold-transition sidebar-mini layout-fixed">
    @include('assets.navbarAdmin')
    @include('assets.sidebarAdmin')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <a href="/admin/encadrant"  style="margin-left: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l5.147 5.146a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                            </svg>
                        </a>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content py-4">
            <div class="container mx-auto px-4">
                <form action="{{ route('encUpdate') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf 
                    @method('POST')
                    @include('assets.success')
           
                    <table class="table-auto w-full">
                        <tr class="mb-4">
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <td class="px-4 py-2"><label for="nom" class="block text-sm font-medium text-gray-700">Nom:</label></td>
                            <td class="px-4 py-2"><input type="text" name="nom" value="{{$data->nom}}" id="nom" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="prenom" class="block text-sm font-medium text-gray-700">Prénom:</label></td>
                            <td class="px-4 py-2"><input type="text" name="prenom" value="{{$data->prenom}}" id="prenom" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="id_dep" class="block text-sm font-medium text-gray-700">Sélectionner un département:</label></td>
                            <td class="px-4 py-2">
                                <select id="id_dep" name="id_dep" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                    @foreach($departements as $item)
                                    @if($item->deleted != 1)
                                        <option value="{{ $item->id }}"
                                            @if($data->id_dep == $item->id) selected 
                                            @endif
                                            >{{ $item->nom }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2" colspan="2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Modifier</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
