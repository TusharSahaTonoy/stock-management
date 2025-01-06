@extends('layouts.main')


@push('styles')
<style>
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        margin: 10px auto;
        display: none;
    }

    .image-preview-wrapper {
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .invalid-feedback {
        display: none;
    }
</style>
@endpush


@section('content')
<!-- Add Product Form -->
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Add New Product</h5>
        </div>
        <div class="card-body">

            @include('layouts.messages')

            <form id="productForm" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Product Details -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name *</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="details" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="productImage" class="form-label">Product Image</label>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="productImage" name="image"
                                        accept="image/*">
                                    <div class="invalid-feedback">
                                        Please select a valid image file (JPG, PNG, GIF, etc.)
                                    </div>
                                </div>
                                <div class="image-preview-wrapper">
                                    <img id="imagePreview" class="image-preview img-thumbnail" src=""
                                        alt="Product Preview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row">
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            {{-- <button type="button" class="btn btn-secondary" id="btnCancel">Cancel</button> --}}
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        // Image preview functionality
        $('#productImage').change(function() {
            const file = this.files[0];
            const $imageInput = $(this);
            const $imagePreview = $('#imagePreview');

            // Reset previous state
            $imageInput.removeClass('is-invalid');
            $imagePreview.hide();

            if (file) {
                // Validate if file is an image
                if (!file.type.startsWith('image/')) {
                    $imageInput.addClass('is-invalid');
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    $imagePreview
                        .attr('src', e.target.result)
                        .show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Form reset handling
        $('#btnCancel').click(function() {
            $('#productForm')[0].reset();
            $('#imagePreview').hide().attr('src', '');
            $('#productImage').removeClass('is-invalid');
        });

        // Form submission handling
        // $('#productForm').submit(function(e) {
        //     e.preventDefault();
        //     // Add your form submission logic here
        //     alert('Form submitted successfully!');
        // });
    });
</script>
@endpush