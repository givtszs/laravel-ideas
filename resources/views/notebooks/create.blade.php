@extends('layout.app')

@section('title', __('notebooks.create_title'))

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layout.left-sidebar')
        </div>

        <div class="col-6">
            <div class="card px-3 py-2">
                <form action="" method="" enctype="multipart/form-data">
                    <h3>Create notebook</h3>

                    <div class="mb-4">
                        <label for="cover" class="form-label">Cover</label>
                        <input class="form-control" id="cover" type="file" accept="image/*" />
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name *</label>
                        <input class="form-control" id="name" type="text"/>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input class="form-control" id="description" type="text"/>
                    </div>

                    <div class="mt-5 d-flex flex-row-reverse">
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
