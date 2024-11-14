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
                        <h1 class="m-0 font-playwrite">Ajouter encadrant</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                       
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content py-4">
            <div class="container mx-auto px-4">
                <form action="{{ route('addEnc') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf 
                    @method('POST')
                    @include('assets.success')
           
                    <table class="table-auto w-full">
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="nom" class="block text-sm font-medium text-gray-700">Nom:</label></td>
                            <td class="px-4 py-2"><input type="text" name="nom" id="nom" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="prenom" class="block text-sm font-medium text-gray-700">Prénom:</label></td>
                            <td class="px-4 py-2"><input type="text" name="prenom" id="prenom" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="id_dep" class="block text-sm font-medium text-gray-700">Sélectionner un département:</label></td>
                            <td class="px-4 py-2">
                                <input type="text" id="searchInput1" class="form-control mb-2" placeholder="Search...">

                                <select name="id_dep" id="id_dep"    class="form-control" onchange="filterEncadrants()">
                                <option ></option>
                                @foreach($data as $departement)
                                @if($departement->deleted != 1)
                                    <option value="{{ $departement->id }}" >{{ $departement->nom }}</option>
                                @endif
                                @endforeach
                            </select>
                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2" colspan="2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </section>
    </div>
    <script>
         $(document).ready(function() {
    $('#searchInput1').on('input', function() {
        var filter = $(this).val().toLowerCase();
        $('#id_dep option').each(function() {
            var text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(filter) > -1);
        });
    });
});
    </script>
</body>
</html>
