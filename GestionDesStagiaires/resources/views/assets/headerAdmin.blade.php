<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Stylesheets -->
    <title>2M</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Playwrite+Deutschland+Grundschrift&display=swap" rel="stylesheet"> --}}
    <link rel="icon" href="{{asset('storage/images/2M_logo.png')}}" type="image/x-icon">
     <link rel="stylesheet" href="{{ asset('css/awesomplete.min.css') }} "> 
   


    <link rel="stylesheet" href="{{asset('css/1.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap4.min.css') }}">
    
    <!-- Optional: Custom Styles -->
    <style>
      
     
    .star-container {
        position: fixed;
        width: 60px; /* Further reduced size */
        height: 60px;
        top: 0;
        left: 5%; 
        width: 100%;
        height: 100%;
        background-color: white;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center; /* Further reduced size */
    }

.star-piece {
    position: absolute;
    width:30px; /* Further reduced size */
    height: 30px; /* Further reduced size */
    background-color: transparent;
    border-top: 10px solid;
    border-right: 10px solid transparent;
    border-bottom: 10px solid;
    border-left: 10px solid transparent;
    transform-origin: 10px 10px; /* Center of the piece */
    border-radius: 20% 0% 0 0; /* Flat corners */
    animation: dot-blink 1.8s infinite step-start;
    opacity: 0;
}

.star-piece.yellow {
    border-color: #FFD700 transparent transparent transparent;
    transform: rotate(0deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0s;
}

.star-piece.orange {
    border-color: #FFA500 transparent transparent transparent;
    transform: rotate(45deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.1s;
}

.star-piece.red {
    border-color: #FF4500 transparent transparent transparent;
    transform: rotate(90deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.2s;
}

.star-piece.pink {
    border-color: #FF69B4 transparent transparent transparent;
    transform: rotate(135deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.3s;
}

.star-piece.purple {
    border-color: #800080 transparent transparent transparent;
    transform: rotate(180deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.4s;
}

.star-piece.darkblue {
    border-color: #00008B transparent transparent transparent;
    transform: rotate(225deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.5s;
}

.star-piece.blue {
    border-color: #1E90FF transparent transparent transparent;
    transform: rotate(270deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.6s;
}

.star-piece.green {
    border-color: #32CD32 transparent transparent transparent;
    transform: rotate(315deg) translate(20px); /* Adjusted translate value */
    animation-delay: 0.7s;
}

@keyframes dot-blink {

    0%, 100% {
        opacity: 0;
    }

    75% {
        opacity: 0.75;
    }
    50% {
        opacity: 1;
    }
    
}

        .font-playwrite {
    font-family: 'Roboto', sans-serif;
}
    </style>
</head>

<body>
    <div class="star-container" id="loading" >
        <div class="star-piece yellow"></div>
        <div class="star-piece green"></div>
        <div class="star-piece blue"></div>
        <div class="star-piece darkblue"></div>
        <div class="star-piece purple"></div>
        <div class="star-piece pink"></div>
        <div class="star-piece red"></div>
        <div class="star-piece orange"></div>
    </div>

    <!-- Content of your page goes here -->


    <script>
        window.addEventListener('load', function() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('content-wrapper').style.display = 'block';
            document.getElementById('navbar1').style.display = 'block';
        });
    </script>
      <script>
        // Add event listener to the entire document
        document.addEventListener('input', function(e) {
            // Check if the event target is an input element and if it's of type "text"
            if (e.target.tagName === 'INPUT' && e.target.type === 'text') {
                // Convert the value to uppercase
                e.target.value = e.target.value.toUpperCase();
            }
        });
    </script>
     <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        function confirmDelete(event) {
    event.preventDefault(); // Prevent the form from submitting immediately
    
    const userConfirmed = confirm("Are you sure you want to delete this record? This action cannot be undone.");
    
    if (userConfirmed) {
        event.target.submit(); // Submit the form if the user confirms
    } else {
        // Do nothing if the user cancels
        return false;
    }
}
    </script>
</body>

</html>