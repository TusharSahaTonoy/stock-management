@extends('layouts.main')
<!-- Include DataTables CSS -->
@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush


@section('content')
<div class="container mt-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Stock Out</h1>
        <nav>
            <a href="#" class="btn btn-primary">Add Stock</a>
        </nav>
    </div>

    <!-- Products List Table -->
    <h3>Available Products</h3>
    <div class="table-responsive mb-4">
        <table id="product-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>
                            <button 
                                class="btn btn-success btn-sm add-to-sell-list" 
                                data-product-id="{{ $item->id }}" 
                                data-product-name="{{ $item->product->name }}" 
                                data-product-stock="{{ $item->stock }}" 
                                data-product-price="{{ $item->price }}">
                                Sell
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No products available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Empty Table for User Input -->
    <h3>Sell Products</h3>
    <form action="{{ route('stock.out-save') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered" id="sell-list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        {{-- <th>Total</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-danger">Complete Sale</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<!-- Include jQuery and DataTables -->


<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('#product-list').DataTable();

        const sellListTable = $('#sell-list tbody');
        let rowCount = 0;

        // Handle Sell Button Click
        $('.add-to-sell-list').on('click', function () {
            const productId = $(this).data('product-id');
            const productName = $(this).data('product-name');
            const productStock = $(this).data('product-stock');
            const productPrice = $(this).data('product-price');

            // Prevent duplicate entries
            if ($(`tr[data-product-id="${productId}"]`).length > 0) {
                alert('This product is already in the sell list.');
                return;
            }

            // Add new row to the sell table
            rowCount++;
            const newRow = `
                <tr data-product-id="${productId}">
                    <td>${rowCount}</td>
                    <td>${productName}</td>
                    <td>
                        <input type="number" name="products[${productId}][quantity]" class="form-control" min="1" max="${productStock}" value="1" step="0.01">
                    </td>
                    <td><input type="number" name="products[${productId}][price]" class="form-control" value="${productPrice}" step="0.01"> </td>
                    
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-from-sell-list">Remove</button>
                    </td>
                </tr>
            `;
            // <td class="total-price">$${productPrice}</td>
            sellListTable.append(newRow);

            // Update total price on quantity change
            sellListTable.find(`tr[data-product-id="${productId}"] input[type="number"]`).on('input', function () {
                const quantity = parseInt($(this).val()) || 0;
                // const totalPriceCell = $(this).closest('tr').find('.total-price');
                // totalPriceCell.text(`$${(quantity * productPrice).toFixed(2)}`);
            });

            // Handle Remove Button
            sellListTable.find(`tr[data-product-id="${productId}"] .remove-from-sell-list`).on('click', function () {
                $(this).closest('tr').remove();
                rowCount--;
            });
        });
    });
</script>
@endpush
