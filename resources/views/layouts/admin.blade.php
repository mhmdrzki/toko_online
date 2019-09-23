<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        @yield('title')
    </title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome5-overrides.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="{{ asset('css/Map-Clean.css') }}">
    <link rel="stylesheet" href="{{ asset('css/smoothproducts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Testimonials.css') }}">

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/navbar/gambar-background-kayu-hd.jpg') }}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.module.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.module.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('container')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('layouts.module.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

    <script>
    $(document).ready(function() {
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        $("#category").on("change", function() {
            const category_id = $(this).val();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            if (category_id != '') {
                $.ajax({
                    url: "{{ route('get-types') }}",
                    type: 'post',
                    data: {
                        _token: CSRF_TOKEN,
                        id: category_id
                    },
                    success: function(data) {
                        $("#type").html(data);
                    }
                });
            } else {
                $("#type").html('<option value=""> Select Type </option>');
            }
        });
        $("#categorySearch").on("change", function() {
                const category = $(this).val();
                const cat = category.replace(/ /g,"-");

                if (category != '') {
                    document.location.href = "{{ url('') }}/p/" + cat.toLowerCase();
                } else {
                    document.location.href = "{{ route('products.index')}}";
                }
            });
            $("#typeSearch").on("change", function() {
                const category = $("#categorySearch").val();
                const type = $(this).val();
                const cat = category.replace(/ /g,"-");

                if (type != '') {
                    document.location.href = "{{ url('') }}/p/" + type + "/" +  cat.toLowerCase();
                } else {
                    document.location.href = "{{ url('') }}/p/" + cat.toLowerCase();
                }
            });
        $('.addTypeModal').on('click', function() {
            $('#TypeModalLabel').html('Add New Type');
            $('.modal-footer button[type=submit]').html('Add Type');
        });
        $('.editTypeModal').on('click', function() {
            const id = $(this).data('id');
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#TypeModalLabel').html('Edit Type');
            $('.modal-footer button[type=submit]').html('Edit Type');
            $('#form').attr('action', "{{ url('types/') }}" + id + "/edit" );

            $.ajax({
                url: "{{ route('get-type') }}",
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#type').val(data.type);
                }
            });

        });
    });
    </script>
</body>

</html>