@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Add Stock Log</h1>

        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control">
        </div>
        <button type="button" id="stock-add-btn" class="btn btn-success mt-3">Add To List</button>

        <form action="{{ route('stock.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table id="stock-add-list" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <button type="submit" id="" class="btn btn-success mt-3">Save</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#stock-add-btn').on('click', function() {
                let product_id = $('#product_id').val();
                let qty = $('#quantity').val();
                let price = $('#price').val();
                let html = '<tr>' +
                    '<td><input type="hidden" name="product_id[]" value="' + product_id +
                    '" />' + product_id + '</td>' +
                    '<td>' + $('#product_id').text() + '</td>' +
                    '<td><input type="hidden" name="qty[]" value="' + qty + '" />' + $(
                        '#quantity').val() + '</td>' +
                    '<td><input type="hidden" name="price[]" value="' + price + '" />' +
                    $('#price').val() + '</td>' +
                    '<td><button class="btn btn-sm btn-danger">Remove</button></td>' +
                    '</tr>';

                $('#stock-add-list tbody').append(html);
            })
        });
    </script>
@endpush
