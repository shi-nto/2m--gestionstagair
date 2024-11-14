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
                        <h1 class="m-0 font-playwrite text-shadow">Ajout stagiaire</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                       
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content py-4">
            <div class="container mx-auto px-4">
               @include('assets.success')
           
                <form action="{{ route('addIntern') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf 
                    @method('POST')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Partie Stagiaire -->
                        <div>
                            <h2 class="text-lg font-medium mb-4">Stagiaire</h2>
                            <div class="mb-4">
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom:</label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
            
                            <div class="mb-4">
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom:</label>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
            
            
                            <div class="mb-4">
                                <label for="institut" class="block text-sm font-medium text-gray-700">Institut:</label>
                                <input type="text" name="institut" id="institut" value="{{ old('institut') }}" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
            
                            <div class="mb-4">
                                <label for="formation" class="block text-sm font-medium text-gray-700">Formation:</label>
                                <input type="text" name="formation" id="formation" value="{{ old('formation') }}" required class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
            
                            <div class="mb-4">
                                <label for="gsm" class="block text-sm font-medium text-gray-700">GSM:</label>
                                <input type="text" name="gsm" id="gsm" required value="{{ old('gsm') }}" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Sexe:</label>
                                <div class="mt-1">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="gender" value="1" @if(old('gender')==1) checked @endif class="form-radio text-indigo-600">
                                        <span class="ml-2">Homme</span>
                                    </label>
                                    <label class="inline-flex items-center ml-6">
                                        <input type="radio" name="gender" value="0" @if(old('gender') == 0) checked @endif class="form-radio text-indigo-600">
                                        <span class="ml-2">Femme</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Partie Entreprise -->
                        <div>
                            <h2 class="text-lg font-medium mb-4">Soread 2M</h2>
                            <div class="mb-4">
                                <label for="nature_stage" class="block text-sm font-medium text-gray-700">Nature du stage:</label>
                                <select name="nature_stage" id="nature_stage" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value=""></option>
                                    <option value="observation"  @if(old('nature_stage') == 'observation') selected @endif >Stage d'observation</option>
                                    <option value="aplication" @if(old('nature_stage') == 'aplication') selected @endif>Stage d'application</option>
                                    <option value="fin_etudes" @if(old('nature_stage') == 'fin_etudes') selected @endif>Stage de fin d'études</option>

                                </select>
                            </div>
                            
            
                            <div class="mb-4">
                                <label for="theme" class="block text-sm font-medium text-gray-700">Thème:</label>
                                <input type="text" name="theme" id="theme" required value="{{ old('theme') }}" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
            
                            <div class="mb-4">
                                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début:</label>
                                <input type="date" name="date_debut" id="date_debut" required value="{{ old('date_debut') }}"
                                       class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                       onchange="calculateDuration()" 
                                       onkeydown="return false;" 
                                       onpaste="return false;" 
                                       oncopy="return false;">
                                @error('date_debut')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            
            
                            <div class="mb-4">
                                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin:</label>
                                <input type="date" name="date_fin" id="date_fin" required  value="{{ old('date_fin') }}"
                                class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                onchange="calculateDuration()"
                                onkeydown="return false;" 
                                onpaste="return false;" 
                                oncopy="return false;">
                            </div>
                            
                            <div class="mb-4">
                                <label for="duree" class="block text-sm font-medium text-gray-700">Durée :</label>
                                <div id="duree" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm sm:text-sm bg-gray-200"></div>
                            </div>  
                            
            
                            <div class="mb-4">
                                <label for="id_dep_search" class="block text-sm font-medium text-gray-700">Département d'accueil:</label>
                                <input type="text" id="id_dep_search" class="form-control mb-2" placeholder="Search..." list="departementsList" autocomplete="off">
                                <datalist id="departementsList">
                                    @foreach($departements as $departement)
                                    @if($departement->deleted==0)
                                        <option value="{{ $departement->nom }}" data-id="{{ $departement->id }}"></option>
                                    @endif
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="id_dep" id="id_dep" class="form-control" required>
                            </div>
            
                            <div class="mb-4">
                                <label for="id_enc_search" class="block text-sm font-medium text-gray-700">Encadrant:</label>
                                <input type="text" id="id_enc_search" class="form-control mb-2" placeholder="Search..." list="encadrantsList" autocomplete="off">
                                <datalist id="encadrantsList">
                                    <!-- Options will be populated dynamically -->
                                </datalist>
                                <input type="hidden" name="id_enc" id="id_enc" required>
                            </div>
            
                            <div class="mb-4">
                                <label for="id_pers_search" class="block text-sm font-medium text-gray-700">Validé par:</label>
                                    <input type="text" id="id_pers_search" value="MAAZOUZ ADIL" class="form-control mb-2" placeholder="Search..." list="encadrantsList2" autocomplete="off">
                                    <datalist id="encadrantsList2">
                                        @foreach($encadrants as $e)
                                        @if($e->deleted==0)
                                            <option value="{{ $e->nom . ' ' . $e->prenom }}" data-id="{{ $e->id }}"></option>
                                            @endif
                                            @endforeach
                                        
                                    </datalist>
                                    <input type="hidden" name="id_pers" id="id_pers" required>
                            </div>
                        </div>
                    </div>
        
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                </form>
            </div>
        </section>
        
    </div>

    <script src="{{asset('js/addInt.js')}}"></script>
    <script src="{{asset('js/jquery-3.3.0.min.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
  
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var encadrants = @json($encadrants); // Fetch encadrants data
    
            var searchInput1 = document.getElementById('id_dep_search');
            var hiddenInput1 = document.getElementById('id_dep');
            var datalist1 = document.getElementById('departementsList');
    
            var searchInput2 = document.getElementById('id_enc_search');
            var hiddenInput2 = document.getElementById('id_enc');
            var datalist2 = document.getElementById('encadrantsList');
    
            function updateEncadrantsList() {
                var selectedDepartementId = hiddenInput1.value;
                datalist2.innerHTML = ''; // Clear existing options
    
                // Filter encadrants based on the selected departement
                var filteredEncadrants = encadrants.filter(enc => enc.id_dep == selectedDepartementId);
    
                // Populate the datalist with the filtered encadrants
                filteredEncadrants.forEach(enc => {
                    var option = document.createElement('option');
                    option.value = enc.nom + ' ' + enc.prenom;
                    option.setAttribute('data-id', enc.id);
                    datalist2.appendChild(option);
                });
            }
    
            // Update encadrants list when departement input changes
            searchInput1.addEventListener('input', function() {
                var selectedOption1 = Array.from(datalist1.options).find(option => option.value === searchInput1.value);
                if (selectedOption1) {
                    hiddenInput1.value = selectedOption1.getAttribute('data-id');
                    updateEncadrantsList(); // Call function to update encadrants list
                } else {
                    hiddenInput1.value = '';
                    datalist2.innerHTML = ''; // Clear encadrants list if no departement is selected
                }
            });
    
            // Update hidden input when encadrant is selected
            searchInput2.addEventListener('input', function() {
                var selectedOption2 = Array.from(datalist2.options).find(option => option.value === searchInput2.value);
                if (selectedOption2) {
                    hiddenInput2.value = selectedOption2.getAttribute('data-id');
                } else {
                    hiddenInput2.value = '';
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchInput2 = document.getElementById('id_enc_search');
            var hiddenInput2 = document.getElementById('id_enc');
            var datalist2 = document.getElementById('encadrantsList');
    
            searchInput2.addEventListener('input', function() {
                var selectedOption2 = Array.from(datalist2.options).find(option => option.value === searchInput2.value);
                if (selectedOption2) {
                    hiddenInput2.value = selectedOption2.getAttribute('data-id');
                } else {
                    hiddenInput2.value = '';
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var searchInput = document.getElementById('id_pers_search');
            var hiddenInput = document.getElementById('id_pers');
            var datalist = document.getElementById('encadrantsList2');
    
            searchInput.addEventListener('input', function() {
                var selectedOption = Array.from(datalist.options).find(option => option.value === searchInput.value);
                if (selectedOption) {
                    hiddenInput.value = selectedOption.getAttribute('data-id');
                } else {
                    hiddenInput.value = '';
                }
            });
            var selectedOption2 = Array.from(datalist.options).find(option => option.value === searchInput.value);

            if (selectedOption2) {
                hiddenInput.value = selectedOption2.getAttribute('data-id');
            } else {
                hiddenInput.value = '';
            }
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var searchInput1 = document.getElementById('id_dep_search');
        var hiddenInput1 = document.getElementById('id_dep');
        var datalist1 = document.getElementById('departementsList');

        searchInput1.addEventListener('input', function() {
            var selectedOption1 = Array.from(datalist1.options).find(option => option.value === searchInput1.value);
            if (selectedOption1) {
                hiddenInput1.value = selectedOption1.getAttribute('data-id');
            } else {
                hiddenInput1.value = '';
            }
        });
    });
</script>

    <script>
        // Sample data for encadrants. In practice, this should be fetched from the server.
        const encadrants = @json($encadrants);

        function filterEncadrants() {
            const id_dep = document.getElementById('id_dep').value;
            const id_enc = document.getElementById('id_enc');
            
            // Clear existing options
            id_enc.innerHTML = '';

            // Filter encadrants based on the selected departement
            const filteredEncadrants = encadrants.filter(enc => enc.id_dep == id_dep);
            
            // Populate the encadrant select with the filtered options
            filteredEncadrants.forEach(enc => {
                const option = document.createElement('option');
                option.value = enc.id;
                option.text = enc.nom+" "+enc.prenom;
                id_enc.appendChild(option);
            });
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            filterEncadrants();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                theme: 'bootstrap4',
                placeholder: 'Select an option',
                allowClear: true // Optional: Allows clearing of the selected option
            });
        });
    </script>
</body>
</html>
