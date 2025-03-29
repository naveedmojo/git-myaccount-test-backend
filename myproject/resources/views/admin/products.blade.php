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
     /* Modals */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow: auto; /* Enables scrolling if needed */
}

/* Modal Content */
.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 50%;
    max-height: 80vh; /* Prevents modal from growing too tall */
    overflow-y: auto; /* Enables vertical scrolling inside modal */
    position: relative;
}

/* Close Button */
.close {
    float: right;
    font-size: 28px;
    cursor: pointer;
}

    input, select {
        display: block;
        width: 100%;
        margin: 10px 0;
        padding: 8px;
    }
     .error-message {
        color: red;
        font-size: 14px;
    }
    </style>

    <div class="container">
        <div class="header">
            <h2>Products</h2>
            <button class="add-product-btn" onclick="openModal()">➕ Add New Product</button>
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

   <div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add New Product</h2>

        <!-- Error Messages -->
        <div id="errorMessages" class="error-message"></div>

        <!-- Product Name -->
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" placeholder="Product Name" required>

        <!-- Sub Category -->
        <label for="subCategoryId">Sub Category:</label>
        <select id="subCategoryId">
            <option value="" disabled selected hidden>Select Sub Category</option>
            @foreach(\App\Models\SubCategory::all() as $subCategory)
            <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
             @endforeach
        </select>

        <!-- Description -->
        <label for="productDescription">Description:</label>
        <input type="text" id="productDescription" placeholder="Description">

        <!-- Price -->
        <label for="productPrice">Price ($):</label>
        <input type="number" id="productPrice" placeholder="Price" required>

        <!-- Product Type -->
        <label for="productType">Product Type:</label>
        <input type="text" id="productType" placeholder="Product Type">

        <!-- Is Sold -->
        <label for="productIsSold">Is Sold:</label>
        <select id="productIsSold">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>

        <!-- Years Used -->
        <label for="productYearsUsed">Years Used:</label>
        <input type="number" id="productYearsUsed" placeholder="Years Used">

        <!-- Image Upload -->
        <label for="productImage">Product Image:</label>
        <input type="file" id="productImage" accept="image/*" required>

        <!-- Image Preview -->
        <img id="productImagePreview" src="" alt="Product Image" style="max-width: 100px; display: block; margin: auto;">

        <!-- Submit Button -->
        <button onclick="submitProduct()">Submit</button>
    </div>
</div>

<div id="editProductModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Product</h2>

        <!-- Error Messages -->
        <div id="editErrorMessages" class="error-message"></div>

        <!-- Hidden Product ID -->
        <input type="hidden" id="editProductId">

        <!-- Product Name -->
        <label for="editProductName">Product Name:</label>
        <input type="text" id="editProductName" placeholder="Product Name" required>

        <!-- Sub Category -->
        <label for="editSubCategoryId">Sub Category:</label>
        <select id="editSubCategoryId">
            <option value="" disabled selected hidden>Select Sub Category</option>
             @foreach(\App\Models\SubCategory::all() as $subCategory)
            <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
             @endforeach
        </select>

        <!-- Description -->
        <label for="editProductDescription">Description:</label>
        <input type="text" id="editProductDescription" placeholder="Description">

        <!-- Price -->
        <label for="editProductPrice">Price ($):</label>
        <input type="number" id="editProductPrice" placeholder="Price" required>

        <!-- Product Type -->
        <label for="editProductType">Product Type:</label>
        <input type="text" id="editProductType" placeholder="Product Type">

        <!-- Is Sold -->
        <label for="editProductIsSold">Is Sold:</label>
        <select id="editProductIsSold">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>

        <!-- Years Used -->
        <label for="editProductYearsUsed">Years Used:</label>
        <input type="number" id="editProductYearsUsed" placeholder="Years Used">

        <!-- Image Upload -->
        <label for="editProductImage">Product Image:</label>
        <input type="file" id="editProductImage" accept="image/*">

        <!-- Image Preview -->
        <img id="editProductImagePreview" src="" alt="Product Image" style="max-width: 100px; display: block; margin: auto;">

        <!-- Update Button -->
        <button onclick="updateProduct()">Update</button>
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
                        <td><img src="/storage/${product.image}" alt="${product.name}"></td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>
                        <td>$${parseFloat(product.price).toFixed(2)}</td>
                        <td>${new Date(product.created_at).toISOString().split('T')[0]}</td>
                        <td>
                             <button class="edit-btn" onclick="openEditModal(${product.id}, '${product.name}', '${product.description}', ${product.price}, '/storage/${product.image}',${product.sub_category_id},'${product.type}',${product.is_sold},${product.years_used})">edit</button>
                              <button class="delete-btn" onclick="deleteProduct(${product.id})">🗑️</button>
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

      function openModal() {
        document.getElementById("productModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("productModal").style.display = "none";
    }
     
    

    function submitProduct() {
        console.log("reached submit prooduct");
        const formData = new FormData();
        formData.append("name", document.getElementById("productName").value);
        formData.append("sub_category_id", document.getElementById("subCategoryId").value);
        formData.append("description", document.getElementById("productDescription").value);
        formData.append("price", document.getElementById("productPrice").value);
        formData.append("type",document.getElementById("editProductType").value);
        formData.append("is_sold",document.getElementById("editProductIsSold").value);
        formData.append("years_used",document.getElementById("editProductYearsUsed").value);



       const imageInput = document.getElementById("productImage");
        if (imageInput.files.length > 0) {
                formData.append("image", imageInput.files[0]); // ✅ Ensure a file is sent
                    }

        fetch("{{ route('admin.products.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                alert("Product created successfully!");
                closeModal();
                location.reload();
            } else {
                let errorMessage = "";
                if (data.error) {
                    errorMessage = `<p>${data.error}</p>`;
                } else if (data.errors) {
                    Object.values(data.errors).forEach(error => {
                        errorMessage += `<p>${error[0]}</p>`;
                    });
                }
                document.getElementById("errorMessages").innerHTML = errorMessage;
            }
        })
        .catch(error => console.error("Error adding Product:", error));
    }
       function updateProduct() {
                
            const productId = document.getElementById("editProductId").value;
            console.log("reached update product",productId);
            const formData = new FormData();
            
            formData.append("name", document.getElementById("editProductName").value);
            formData.append("sub_category_id", document.getElementById("editSubCategoryId").value);
            formData.append("description", document.getElementById("editProductDescription").value);
            formData.append("price", document.getElementById("editProductPrice").value);
            formData.append("type", document.getElementById("editProductType").value);
            formData.append("is_sold", document.getElementById("editProductIsSold").value);
            formData.append("years_used", document.getElementById("editProductYearsUsed").value);

            const imageInput = document.getElementById("editProductImage");
            if (imageInput.files.length > 0) {
                formData.append("image", imageInput.files[0]);
            }

            fetch(`/admin/products/product/update/${productId}`, { 
                method: "POST", // Change to PUT if your route supports it
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert("Product updated successfully!");
                    closeEditModal();
                    location.reload();
                } else {
                    let errorMessage = "";
                    if (data.error) {
                        errorMessage = `<p>${data.error}</p>`;
                    } else if (data.errors) {
                        Object.values(data.errors).forEach(error => {
                            errorMessage += `<p>${error[0]}</p>`;
                        });
                    }
                    document.getElementById("editErrorMessages").innerHTML = errorMessage;
                }
            })
            .catch(error => console.error("Error updating product:", error));
        }
function deleteProduct(productId) {
    
        if (confirm("Are you sure you want to delete this product?")) {
            fetch(`/admin/products/product/delete/${productId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    alert("Product deleted successfully!");
                    location.reload();
                } else {
                    alert("Error deleting product.");
                  
                }
            })
            .catch(error => console.error("Error deleting product:", error));
        }
    }

function openEditModal(id, name, description, price, image, subCategoryId,type,isSold,yearsUsed) {

    document.getElementById("editProductId").value = id;
    document.getElementById("editProductName").value = name;
    document.getElementById("editProductDescription").value = description;
    document.getElementById("editProductPrice").value = price;
    document.getElementById("editProductImagePreview").src = image;
    document.getElementById("editSubCategoryId").value = subCategoryId;
    document.getElementById("editProductType").value=type;
    document.getElementById("editProductIsSold").value=isSold;
    document.getElementById("editProductYearsUsed").value=yearsUsed;
    
    // Clear previous error messages when opening the modal
    document.getElementById("editErrorMessages").innerHTML = "";

    document.getElementById("editProductModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editProductModal").style.display = "none";
}


</script>

@endsection
