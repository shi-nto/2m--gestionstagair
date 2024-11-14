<style>
.custom-navbar {
    border-radius: 10px; /* Round corners */

    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow */
}

    .header {
        font-family : "consolas" , sans-serif;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    h1{
        font-family : "consolas" , sans-serif;

    }
</style>

<nav id="navbar1" class="main-header navbar navbar-expand navbar-white navbar-light custom-navbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" role="button">
                <i class="fas fa-sign-out-alt w-6 h-6 inline"></i>
            </a>
        </li>
    </ul>
</nav>
