@extends('admin.layout')

@section('title', 'Products')

@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }
        
        .button {
            display: inline-block;
            padding: 12px 18px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .button:hover {
            background: #0056b3;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        thead {
            background: #007bff;
            color: white;
        }
        
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
      tbody tr:hover {
    background-color: #f1f1f1;
        }   

        
        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        
        .action-links a, .delete-btn {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            margin-right: 12px;
            transition: 0.3s;
        }
        
        .delete-btn {
            color: #dc3545;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .delete-btn:hover {
            color: #b02a37;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 8px;
        }

      .pagination a {
        padding: 10px 14px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 50%; /* Makes the links round */
        font-weight: bold;
        transition: 0.3s;
        margin: 0 6px; /* Adds spacing between the links */
        display: inline-flex;
        align-items: center;
        justify-content: center;
            }

        .pagination a:hover {
            background: #0056b3;
        }

        .pagination .active {
            background: #0056b3;
            pointer-events: none;
        }

    </style>

    <div class="container">
        <div class="header">
            <h2>Products</h2>
            <a href="{{ route('admin.products.store') }}" class="button">+ Add Product</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="product-table-body">
                <!-- Dynamic Data Will Be Loaded Here -->
            </tbody>
        </table>

        <div class="pagination">
            <nav id="pagination-links"></nav>
        </div>
    </div>

    <script>
   document.addEventListener('DOMContentLoaded', function () {
    fetchProducts();

    function fetchProducts(page = 1) {
        fetch(`{{ route('admin.products.index') }}?page=${page}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            let tbody = document.getElementById('product-table-body');
            tbody.innerHTML = '';

            if (!data.data) {
                console.error('Invalid response format', data);
                return;
            }

            data.data.forEach(product => {
                tbody.innerHTML += `
                    <tr>
                        <td>${product.id}</td>
                        <td><img src="/storage/products/${product.image}" alt="${product.name}"></td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>$${parseFloat(product.price).toFixed(2)}</td>
                        <td>${new Date(product.created_at).toISOString().split('T')[0]}</td>
                        <td>
                            <a href="/admin/products/${product.id}/edit">Edit</a>
                            <form action="/admin/products/${product.id}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;
            });

            setupPagination(data);
        })
        .catch(error => console.error('Error fetching products:', error));
    }

    function setupPagination(data) {
        let paginationContainer = document.getElementById('pagination-links');
        paginationContainer.innerHTML = '';

        let currentPage = data.current_page;
        let lastPage = data.last_page;

        if (lastPage > 1) {
            for (let i = 1; i <= lastPage; i++) {
                let activeClass = i === currentPage ? 'active' : '';
                paginationContainer.innerHTML += `<a href="#" class="${activeClass}" data-page="${i}">${i}</a>`;
            }

            document.querySelectorAll('#pagination-links a').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    let page = this.getAttribute('data-page');
                    fetchProducts(page);
                });
            });
        }
    }
});

</script>

@endsection
