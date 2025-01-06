<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Product Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('product.index') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('product.add') }}">Product Add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('stock.add')}}">Stock In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('stock.out')}}">Stock Out</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#reports">Reports</a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
