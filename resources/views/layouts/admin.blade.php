<!doctype html>
<html>

<head>
    <title>@yield('title')</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

</head>

<body>

    <!-- navigation bar -->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 offset-sm-3 col-md-6 offset-md-3">

                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/courses">Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/academicyears">Academic Year</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/studyplans">Study Plan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/logs">Log</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>

            </div>
        </div>
    </div>
    <!-- navigation bar ends here -->


    @yield('content')


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</body>

</html>
