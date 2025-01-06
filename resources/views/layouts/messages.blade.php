@if ($errors->any())
<div class="alert alert-danger">
    <h6>Please correct the following errors:</h6>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
