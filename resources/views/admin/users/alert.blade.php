@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif

{{-- @if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif --}}


<script>
    @if (Session::has('success'))
        setTimeout(function() {
            showSuccessMessage("{{ Session::get('success') }}");
        }, 1000); // 2000 milliseconds = 2 seconds
    @endif
</script>
