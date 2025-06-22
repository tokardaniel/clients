<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'cím')</title>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets/js/clients.js') }}?v=moh9Iaza"></script>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <form class="d-flex">
            <input type="button" class="btn btn-outline-secondary me-2" id="clients_button" value="Keresés"
                data-bs-toggle="modal" data-bs-target="#searchModal">
        </form>
    </div>
    </div>
</nav>

<body>
    @yield('content')
</body>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalTitle">Ügyfélkeresés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible" role="alert" id="errorMsgAlert" style="display: none">
                    <strong>Hibás keresési adatok!</strong>
                    <div id="errorMsgContent"></div>
                </div>

                <form id="search_form">
                    <div class="mb-3">
                        <label for="client_name_input" class="form-label">Ügyfél neve</label>
                        <input type="text" class="form-control" id="client_name_input" placeholder="Ügyfél neve">
                    </div>
                    <div class="mb-3">
                        <label for="client_id_input" class="form-label">Ügyfél okmányazonosító</label>
                        <input type="text" class="form-control" id="client_id_input" placeholder="1234567890">
                    </div>
                    <button class="btn btn-primary" type="submit">Keresás</button>
                </form>
                <div id="search_result_container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezárás</button>
            </div>
        </div>
    </div>
</div>

</html>
