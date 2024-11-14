<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.headerAdmin')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
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
                        <h1 class="m-0 font-playwrite">Ajouter département</h1>
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
                @include('assets.success')
           
                
                <form action="{{ route('addDep') }}" method="POST" class="bg-white rounded-lg p-8 mb-6">
                    @csrf
                    @method('post')
                    
                    <table class="table-auto w-full">
                        <tr class="mb-6">
                            <td class="px-4 py-2"><label for="nom" class="block text-gray-800 text-sm font-semibold mb-2">Nom</label></td>
                            <td class="px-4 py-2">
                                <input type="text" name="nom" id="nom" placeholder="Nom" class="appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('nom')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr class="mb-6">
                            <td class="px-4 py-2" colspan="2">
                                <div class="flex items-center justify-end">
                                    <input type="submit" value="Ajouter" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
