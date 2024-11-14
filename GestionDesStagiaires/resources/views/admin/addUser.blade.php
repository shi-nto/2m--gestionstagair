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
                        <h1 class="m-0 font-playwrite">Ajouter utilisateur</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content py-4">
            <div class="container mx-auto px-4">
                <form action="{{ route('addUser') }}" method="post" class="bg-white rounded px-8 pt-6 pb-8 mb-4">
                    @csrf 
                    @method('post')
                    @include('assets.success')
           
                    <table class="table-auto w-full">
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="first_name" class="block text-sm font-medium text-gray-700">First Name:</label></td>
                            <td class="px-4 py-2">
                                <input type="text" id="first_name" name="first_name" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="second_name" class="block text-sm font-medium text-gray-700">Second Name:</label></td>
                            <td class="px-4 py-2">
                                <input type="text" id="second_name" name="second_name" required class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="userName" class="block text-sm font-medium text-gray-700">UserName:</label></td>
                            <td class="px-4 py-2">
                                <input type="text" id="userName" name="userName" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('userName')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                           
                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="password" class="block text-sm font-medium text-gray-700">Password:</label></td>
                            <td class="px-4 py-2">
                                <div class="relative"> 
                                    <input type="password" id="password" name="password" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="button" class="absolute right-2 top-2 text-gray-500" onclick="togglePasswordVisibility(this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                </div>                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2"><label for="role" class="block text-sm font-medium text-gray-700">Role:</label></td>
                            <td class="px-4 py-2">
                                <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </td>
                        </tr>
                        <tr class="mb-4">
                            <td class="px-4 py-2" colspan="2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </section>
    </div>

    <script>
        function togglePasswordVisibility(button) {
            const input = button.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                button.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
