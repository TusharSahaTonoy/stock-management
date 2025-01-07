@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Stock Add Page</h1>

    <!-- Add Product Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="product-name">Product</label>
            <select id="product-name" class="form-control">
                <option value="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="stock-quantity">Quantity</label>
            <input type="number" id="stock-quantity" class="form-control" placeholder="Enter quantity">
        </div>
        <div class="col-md-3">
            <label for="product-price">Price</label>
            <input type="number" id="product-price" class="form-control" placeholder="Enter price">
        </div>
        <div class="col-md-2">
            <button id="add-to-list" class="btn btn-primary mt-4">Add To List</button>
        </div>
    </div>

    <!-- Stock Add List Table -->
    <form action="{{route('stock.store')}}" method="post">
        @csrf
        <div class="table-responsive">
            <table id="stock-add-list" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be added dynamically -->
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
    
</div>

<!-- Include Select2 and Custom Scripts -->
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#product-name').select2({
            placeholder: "Select a product",
            allowClear: true
        });

        // Auto-fill price field when a product is selected
        $('#product-name').on('change', function() {
            const selectedOption = $(this).find(':selected');
            const price = selectedOption.data('price') || '';
            $('#product-price').val(price);
        });

        // Add to List Button Click
        $('#add-to-list').on('click', function() {
            const productId = $('#product-name').val();
            const productName = $('#product-name option:selected').text();
            const quantity = $('#stock-quantity').val();
            const price = $('#product-price').val();

            // Validation: Check if product is selected, quantity, and price are valid
            if (!productId || quantity <= 0 || price <= 0) {
                alert('Please select a valid product, quantity, and price.');
                return;
            }

            // Validation: Check for duplicate product
            if ($(`#stock-add-list tbody tr[data-id="${productId}"]`).length > 0) {
                alert('This product is already in the list.');
                return;
            }

            // Add a new row to the table
            $('#stock-add-list tbody').append(`
                <tr data-id="${productId}">
                    <td>${productName}</td>
                    <td><input type="number" class="form-control" name="products[${productId}][qty]" value="${quantity}" step="0.01"/></td>
                    <td><input type="number" class="form-control" name="products[${productId}][price]" value="${price}" step="0.01"/></td>
                    <td><button class="btn btn-danger btn-sm remove-row">Remove</button></td>
                </tr>
            `);

            // Clear inputs
            $('#product-name').val('').trigger('change');
            $('#stock-quantity').val('');
            $('#product-price').val('');
        });

        // Remove Row Button Click
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
@endpush

@endsection
