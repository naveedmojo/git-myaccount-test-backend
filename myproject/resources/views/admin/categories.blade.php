@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .container {
        width: 90%;
        margin: auto;
        text-align: center;
    }
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }
    .add-category-btn {
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }
    .add-category-btn:hover {
        background: #0056b3;
    }
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    .category-card {
         position: relative; 
        padding: 20px;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        text-align: center;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        background: #f9f9f9;
    }
    .category-card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    .category-card h3 {
        margin: 10px 0 5px;
        color: #333;
    }
    .category-card p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
        text-align: center;
    }
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
   .edit-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
   
    display: none; /* Hide button by default */
}
    .category-card:hover .edit-btn {
    display: block; /* Show button on hover */
    }

</style>

<div class="container">
    <div class="header-container">
        <h2 class="title">📁 Categories</h2>
        <button class="add-category-btn" onclick="openModal()">➕ Add New Category</button>
    </div>
    <div class="category-grid" id="categories-container">
        <!-- Categories will be loaded here dynamically -->
    </div>
</div>

<div id="categoryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Add New Category</h2>
         <div id="errorMessages" class="error-message"></div>
        <input type="text" id="categoryName" placeholder="Category Name" required>
      <select id="mainCategoryId">
         <option value="" disabled selected hidden>Select Main Category</option>
         <option value="1">Main Category 1 (ps4)</option>
        <option value="2">Main Category 2 (ps5)</option>
    </select>
        <input type="text" id="categoryDescription" placeholder="Description">
        <input type="number" id="categoryStock" placeholder="Stock" required>
        <input type="file" id="categoryImage" accept="image/*" required>
        <button onclick="submitCategory()">Submit</button>
    </div>
</div>

<div id="editCategoryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Category</h2>
        <div id="editErrorMessages" class="error-message"></div>
        <input type="hidden" id="editCategoryId">
        <input type="text" id="editCategoryName" placeholder="Category Name" required>
         <select id="editMainCategoryId">
            <option value="" disabled selected hidden>Select Main Category</option>
            <option value="1">Main Category 1 (PS4)</option>
            <option value="2">Main Category 2 (PS5)</option>
        </select>
        <input type="text" id="editCategoryDescription" placeholder="Description">
        <input type="number" id="editCategoryStock" placeholder="Stock" required>
        <input type="file" id="editCategoryImage" accept="image/*">
        <img id="editCategoryImagePreview" src="" alt="Category Image" style="max-width: 100px; display: block; margin: auto;">
        <button onclick="updateCategory()">Update</button>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ route('admin.subcategories.index') }}")
            .then(response => response.json())
            .then(data => {
                if (data.status && data.data) {
                    const container = document.getElementById("categories-container");
                    container.innerHTML = "";
                    data.data.forEach(category => {
                        const card = document.createElement("div");
                        card.classList.add("category-card");
                        card.innerHTML = `
                        <button class="edit-btn" onclick="openEditModal(${category.id}, '${category.name}', '${category.description}', ${category.stock}, '/storage/${category.image}',${category.main_category_id})">✏️</button>
                            <img src="/storage/${category.image}" alt="${category.name}">
                            <h3>${category.name}</h3>
                            <p>${category.description || 'No description available'}</p>
                            <p><strong>Stock:</strong> ${category.stock}</p>
                        `;
                        container.appendChild(card);
                    });
                }
            })
            .catch(error => console.error("Error fetching categories:", error));
    });

     function openModal() {
        document.getElementById("categoryModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("categoryModal").style.display = "none";
    }
     function openEditModal(id, name, description, stock, image,mainCategoryId) {
        document.getElementById("editCategoryId").value = id;
        document.getElementById("editCategoryName").value = name;
        document.getElementById("editCategoryDescription").value = description;
        document.getElementById("editCategoryStock").value = stock;
        document.getElementById("editCategoryImagePreview").src = image;

         document.getElementById("editMainCategoryId").value = mainCategoryId;
        document.getElementById("editCategoryModal").style.display = "block";
    }
     function closeEditModal() {
        document.getElementById("editCategoryModal").style.display = "none";
    }

    function submitCategory() {
        const formData = new FormData();
        formData.append("name", document.getElementById("categoryName").value);
        formData.append("main_category_id", document.getElementById("mainCategoryId").value);
        formData.append("description", document.getElementById("categoryDescription").value);
        formData.append("stock", document.getElementById("categoryStock").value);
       const imageInput = document.getElementById("categoryImage");
        if (imageInput.files.length > 0) {
                formData.append("image", imageInput.files[0]); // ✅ Ensure a file is sent
                    }

        fetch("{{ route('admin.subcategories.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                alert("Category created successfully!");
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
        .catch(error => console.error("Error adding category:", error));
    }
    function updateCategory() {
    const categoryId = document.getElementById("editCategoryId").value;
    const formData = new FormData();
    
    formData.append("name", document.getElementById("editCategoryName").value);
    formData.append("main_category_id", document.getElementById("editMainCategoryId").value);
    formData.append("description", document.getElementById("editCategoryDescription").value);
    formData.append("stock", document.getElementById("editCategoryStock").value);

    const imageInput = document.getElementById("editCategoryImage");
    if (imageInput.files.length > 0) {
        formData.append("image", imageInput.files[0]);
    }

    fetch(`/admin/categories/sub/update/${categoryId}`, { 
        method: "POST", // Change to PUT if your route supports it
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            alert("Category updated successfully!");
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
    .catch(error => console.error("Error updating category:", error));
}

function openEditModal(id, name, description, stock, image, mainCategoryId) {
    document.getElementById("editCategoryId").value = id;
    document.getElementById("editCategoryName").value = name;
    document.getElementById("editCategoryDescription").value = description;
    document.getElementById("editCategoryStock").value = stock;
    document.getElementById("editCategoryImagePreview").src = image;
    document.getElementById("editMainCategoryId").value = mainCategoryId;
    
    // Clear previous error messages when opening the modal
    document.getElementById("editErrorMessages").innerHTML = "";

    document.getElementById("editCategoryModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editCategoryModal").style.display = "none";
}


</script>
@endsection
