<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.headerAdmin')
    <title>2M</title>
    <link rel="stylesheet" href="{{asset('select2.min.css')}}">
    <style>
        .select2-container .select2-selection--single {
            height: 36px;
        }
        .select2-container--bootstrap4 .select2-selection--single {
            padding: 0.375rem 0.75rem;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @include('assets.navbarAdmin')
    @include('assets.sidebarAdmin')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex align-items-center">
                        <a href="/home" style="margin-left: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l5.147 5.146a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content py-4">
            <div class="container mx-auto px-4">
                @include('assets.success')
                <form action="{{route('prolonge')}}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf 
                    @method('post')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700  ">Nom:</label>
                            <input type="text" name="nom" id="nom" value="{{$data->nom}}" disabled class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <input type="hidden" name="id_stag" value="{{$data->id}}">
                        </div>

                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom:</label>
                            <input type="text" name="prenom" id="prenom" value="{{$data->prenom}}" disabled class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début:</label>
                            <input type="date" name="" id="" value="{{$data->date_debut}}" disabled class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <input type="hidden" name="date_debut" id="date_debut" value="{{$data->date_debut}}" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                        </div>

                        <div class="mb-4">
                            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de fin:</label>
                            <input type="date" name="" id="" value="{{$data->date_fin}}" disabled class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <input type="hidden" name="date_fin_old" id="date_fin_old" value="{{$data->date_fin}}" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                        </div>
                        <div class="mb-4">
                            <label for="id_dep_search" class="block text-sm font-medium text-gray-700">Département d'accueil:</label>
                                <input type="text" id="id_dep_search"  class="form-control mb-2" placeholder="Search..." list="departementsList" autocomplete="off">
                                <datalist id="departementsList">
                                    @foreach($departements as $departement)
                                    @if($departement->deleted==0)
                                        <option value="{{ $departement->nom }}" data-id="{{ $departement->id }}"></option>
                                    @endif
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="id_dep" id="id_dep" class="form-control" >
                        </div>

                        <div class="mb-4">
                            <label for="id_enc_search" class="block text-sm font-medium text-gray-700">Encadrant:</label>
                                <input type="text" id="id_enc_search" class="form-control mb-2" placeholder="Search..." list="encadrantsList" autocomplete="off">
                                <datalist id="encadrantsList">
                                    <!-- Options will be populated dynamically -->
                                </datalist>
                                <input type="hidden" name="id_enc" id="id_enc" >
                                <input type="hidden" name="old_enc" value="{{$data->id_enc}}">
                        </div>
                        <div class="mb-4">
                            <label for="id_pers_search" class="block text-sm font-medium text-gray-700">Validé par:</label>
                            <input type="text" id="id_pers_search" class="form-control mb-2" value="MAAZOUZ ADIL" placeholder="Search..." list="encadrantsList2" autocomplete="off">
                            <datalist id="encadrantsList2">
                                @foreach($encadrants as $e)
                                @if($e->deleted==0)
                                    <option value="{{ $e->nom . ' ' . $e->prenom }}" data-id="{{ $e->id }}"></option>
                                    @endif
                                    @endforeach
                                
                            </datalist>
                            <input type="hidden" name="id_pers" id="id_pers" >
                            <input type="hidden" name="old_pers" value="{{$data->personnel->id}}">
                        </div>

                        <div class="mb-4">
                            <label for="date_fin" class="block text-sm font-medium text-gray-700">Nouveau date de fin:</label>
                            <input type="date" name="date_fin" id="date_fin" required  onchange="calculateDuration()"  class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="motif" class="block text-sm font-medium text-gray-700">Motif de prolongation:</label>
                            <textarea name="motif" id="motif" rows="4"  placeholder="Entrez la raison de la prolongation" class="mt-1 px-4 py-2 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
                </form>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="{{asset("js/prolong.js")}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            calculateDuration();
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
