<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('../lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('../lib/slick/slick.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('../js/main.js') }}"></script>

<script src="{{ asset('js/alert.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.successMessage = @json(Session::get('success'));
    window.errorMessage = @json(Session::get('error'));
    window.validationErrors = @json($errors->all());
</script>

@auth()
    <meta name="user-id" content="{{ Auth::user()->id }}">
    @vite(['resources/js/app.js'])
@endauth
