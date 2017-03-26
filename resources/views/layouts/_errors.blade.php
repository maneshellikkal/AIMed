@if (count($errors) > 0)
    <div class="container">
        <div class="row justify-content-md-center mt-3">
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
