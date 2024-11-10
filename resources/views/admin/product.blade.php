<div class="row p-5">
    <div class="col-md-9">
        <div class="container">
            <form action="{{ asset('admin') }}" method="get" class="mb-4">
                <div class="input-group input-group-merge speech-to-text bg-white w-100 hover-shadow">
                    <input type="text" name="keyword" class="form-control" placeholder="Search"
                        value="{{ Request::get('keyword') }}" aria-describedby="text-to-speech-addon">
                    <button type="submit" class="btn btn-primary btn-main" style="margin-left: 10px;">
                        <i class='fas fa-magnifying-glass'></i>
                    </button>
                </div>
            </form>
            <div class="row">
                <div class="col-sm-4 mt-3 mb-5">
                    <div class="card hover-shadow" data-aos="fade-up"
                        style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); cursor: pointer; height: 100%; background-color: #F5F5F5;"
                        data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <div class="card-body text-center d-flex flex-column justify-content-center"
                            style="padding: 20px;">
                            <h5 class="card-title"
                                style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 50px; color: #4F2B00;">
                                <i class="fas fa-plus-circle"></i>
                            </h5>
                        </div>
                    </div>
                </div>
                <!-- Modal for Adding New Product -->
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-5">
                                <form id="addProductForm" action="{{ asset('admin/product/store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <h5>Add Product</h5>
                                    <div class="mb-3 mt-5">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control rounded-3" id="productName"
                                            name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCode" class="form-label">Product Code</label>
                                        <input type="text" class="form-control rounded-3" id="productCode" name="code" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productColor" class="form-label">Product Color</label>
                                        <input type="text" class="form-control rounded-3" id="productColor" name="color" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productMaterial" class="form-label">Product Material</label>
                                        <input type="text" class="form-control rounded-3" id="productMaterial" name="material" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productSize" class="form-label">Product Size</label>
                                        <input type="text" class="form-control rounded-3" id="productSize" name="size" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productCategory" class="form-label">Category</label>
                                        <select class="form-select" id="productCategory" name="category_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productImage" class="form-label">Product Image <small class="text-danger">* Max 4 Image</small></label>
                                        <input type="file" class="form-control" multiple id="productImage" name="image[]"
                                            required>
                                    </div>
                                    <div class="mt-5">
                                        <button type="submit" form="addProductForm"
                                            class="btn btn-success">Add</button>
                                        <button type="button" class="btn btn-secondary btn-main"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($products as $product)
                    <div class="col-sm-4 mt-3">
                        <div class="card hover-shadow" data-aos="fade-up"
                            style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <a data-bs-toggle="modal" onclick="getProductDetail('{{ $product->id }}')" data-bs-target="#productDetail" data-lightbox="product"
                                data-title="{{ $product->name }}">
                                <img src="{{ asset('storage/products/' . $product->images[0]->image) }}" alt="{{ $product->name }}"
                                    class="card-img-top" style="object-fit: cover; border-radius: 20px 20px 0 0;">
                            </a>
                            <div class="card-body text-center" style="padding: 20px;">
                                <h5 class="card-title"
                                    style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 18px; color: #4F2B00;">
                                    {{ $product->name }}</h5>
                                <span class="text-primary"
                                    style="font-size: 12px; font-weight: bold;">{{ $product->category ? $product->category->name : 'uncategorized' }}</span>
                                <div class="mt-3">
                                    <button class="btn btn-warning btn-sm"
                                        onclick="openEditModal('{{ $product->id }}')">Edit</button>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmDeleteProduct('{{ $product->id }}')">Delete</button>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick="getProductDetail('{{ $product->id }}')" data-bs-target="#productDetail">Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Modal -->
                <div class="modal fade" id="productDetail" tabindex="-1" aria-labelledby="productModalLabe" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-body" id="modalBody">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 p-5">
                                        <img src="" alt="" id="detailProductImage" class="w-100 mb-4 rounded border-image">
                                        <div class="list-image-container">
                                            <div class="list-image-inner d-flex overflow-x-auto" id="detailProductImageList">
                                                <img src="{{ asset('storage/products/1.png') }}" alt="" id="detailProductImage" class="img-fluid image-list">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 p-5">
                                        <div class="mb-3">
                                            <h3>
                                                <span id="detailProductName" class="fw-bold text-uppercase"></span>
                                            </h3>
                                            <h5 id="detailProductCode" class="fw-bold text-info"></h5>
                                            <small id="detailProductCategory" class="text-warning mt-3 text-uppercase fw-bold"></small>
                                        </div>
                                        <span class="badge bg-primary" id="detailProductSize" style="font-size: 12px;"></span>
                                        <div class="mt-5">
                                            <span class="fw-bold">Color :</span> <span id="detailProductColor" class="text-muted"></span>
                                        </div>
                                        <div class="mt-5">
                                            <span class="fw-bold">Material :</span> <span id="detailProductMaterial" class="text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-5 mb-5">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="">
            <div class="filter-container" data-aos="fade-up">
                <div class="d-flex justify-content-center">
                    <h5 style="font-size: 16px" class="fw-bold">Category</h5>
                </div>
                <div style="max-height: 400px; overflow-y: auto;">
                    <div class="form-check">
                        <a href="#" class="form-check-label text-success fw-bold text-decoration-none"
                            for="newCategory" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fas fa-plus-circle"></i> Add Category
                        </a>
                    </div>
                    <form action="{{ asset('admin') }}" method="GET">
                        @foreach ($categories as $category)
                            <div class="form-check d-flex justify-content-between">
                                <div>
                                    <input class="form-check-input" type="checkbox" name="filter_category[]" value="{{ $category->id }}"
                                        id="{{ $category->name }}" @if(request()->has('filter_category') && in_array($category->id, request('filter_category'))) checked @endif>
                                    <label class="form-check-label"
                                        for="{{ $category->name }}">{{ $category->name }}</label>
                                </div>
                                <div>
                                    <a href="#" class="text-danger"
                                        onclick="confirmDeleteCategory('{{ $category->id }}')"><i
                                            class="fas fa-trash-alt"></i></a>
                                    <a href="#" class="text-primary"
                                        onclick="openUpdateModal('{{ $category->name }}', '{{ $category->id }}')"><i
                                            class="fas fa-edit"></i></a>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-check">
                            <a href="#" class="form-check-label text-success fw-bold text-decoration-none"
                                for="newCategory" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="fas fa-plus-circle"></i> Add Category
                            </a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-main mt-3 w-100">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding New Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="addCategoryForm" action="{{ asset('admin/category/store') }}" method="post">
                    @csrf
                    <h5>Add Category</h5>
                    <div class="mb-3 mt-5">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control rounded-3" id="categoryName" name="name"
                            required>
                    </div>
                    <div class="mt-5">
                        <button type="submit" form="addCategoryForm" class="btn btn-success">Add</button>
                        <button type="button" class="btn btn-secondary btn-main"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Updating Category -->
<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="updateCategoryForm" action="{{ asset('admin/category/update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="categoryId">
                    <h5>Update Category</h5>
                    <div class="mb-3 mt-5">
                        <label for="updateCategoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control rounded-3" id="updateCategoryName" name="name"
                            required>
                    </div>
                    <div class="mt-5">
                        <button type="submit" form="updateCategoryForm" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary btn-main"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Updating Product -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-5">
                <form id="updateProductForm" action="{{ asset('admin/product/update') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="updateProductId">
                    <h5>Update Product</h5>
                    <div class="mb-3 mt-5">
                        <label for="updateProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control rounded-3" id="updateProductName" name="name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="updateProductCode" class="form-label">Product Code</label>
                        <input type="text" class="form-control rounded-3" id="updateProductCode" name="code"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="updateProductColor" class="form-label">Product Color</label>
                        <input type="text" class="form-control rounded-3" id="updateProductColor" name="color"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="updateProductMaterial" class="form-label">Product Material</label>
                        <input type="text" class="form-control rounded-3" id="updateProductMaterial" name="material"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="updateProductSize" class="form-label">Product Size</label>
                        <input type="text" class="form-control rounded-3" id="updateProductSize" name="size"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="updateProductCategory" class="form-label">Category</label>
                        <select class="form-select" id="updateProductCategory" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateProductImage" class="form-label">Product Image <small class="text-danger">* Max 4 Image</small></label>
                        <input type="file" class="form-control" multiple id="updateProductImage" name="image[]">
                    </div>
                    <div class="mb-3" id="updateProductImageList" style="display: flex; flex-wrap: wrap;">
                        <div class="image-list-container">
                            <img src="{{ asset('storage/products/1.png') }}" alt="" class="img-fluid image-list">
                            <span class="delete-icon"><i class="fas fa-trash text-danger"></i></span>
                        </div>
                        <div class="image-list-container">
                            <img src="{{ asset('storage/products/1.png') }}" alt="" class="img-fluid image-list">
                            <span class="delete-icon"><i class="fas fa-trash text-danger"></i></span>
                        </div>
                        <div class="image-list-container">
                            <img src="{{ asset('storage/products/1.png') }}" alt="" class="img-fluid image-list">
                            <span class="delete-icon"><i class="fas fa-trash text-danger"></i></span>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" form="updateProductForm" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary btn-main"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-body">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <p id="error-message"></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@section('custom-js')
@if ($errors->any())
    <script>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        document.getElementById('error-message').innerText = '{{ $errors->first() }}';
        errorModal.show();
    </script>
@endif
@if (session('error'))
    <script>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        document.getElementById('error-message').innerText = '{{ session('error') }}';
        errorModal.show();
    </script>
@endif
<script>
    function openUpdateModal(categoryName, categoryId) {
        document.getElementById('updateCategoryName').value = categoryName;
        document.getElementById('categoryId').value = categoryId;

        var updateModal = new bootstrap.Modal(document.getElementById('updateCategoryModal'));
        updateModal.show();
    }


    function openEditModal(productId) {
        document.getElementById('updateProductId').value = productId;
        $.ajax({
            url: "{{ asset('collection/product') }}/" + productId,
            method: 'GET',
            success: function(response) {
                document.getElementById('updateProductName').value = response.name;
                document.getElementById('updateProductCode').value = response.code;
                document.getElementById('updateProductColor').value = response.color;
                document.getElementById('updateProductMaterial').value = response.material;
                document.getElementById('updateProductSize').value = response.size;
                document.getElementById('updateProductCategory').value = response.category_id;
                $('#updateProductImageList').html('');
                response.images.forEach(image => {
                    $('#updateProductImageList').append('<div class="image-list-container" id="image-list-container-' + image.id + '"><img src="' + image.image + '" alt="" class="img-fluid image-list "><span class="delete-icon" onclick="deleteImage(' + image.id + ')"><i class="fas fa-trash text-danger"></i></span></div>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        var updateModal = new bootstrap.Modal(document.getElementById('updateProductModal'));
        updateModal.show();
    }

    function deleteImage(imageId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ asset('/admin/product/image/delete') }}/" + imageId,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#image-list-container-' + image.id).remove();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
    }
</script>
<script>
    function confirmDeleteProduct(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ asset('/admin/product/delete') }}/" + productId;
            }
        });
    }
    function confirmDeleteCategory(categoryId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ asset('/admin/category/delete') }}/" + categoryId;
            }
        });
    }

    function getProductDetail(id) {
        $.ajax({
            url: '{{asset('/collection/product/')}}/' + id,
            method: 'GET',
            success: function(data) {
                handleAjaxResponse(data);
            }
        });
    }

    function handleAjaxResponse(response) {
        $('#detailProductName').text(response.name);
        $('#detailProductCode').text(response.code);
        $('#detailProductCategory').text(response.category.name);
        $('#detailProductColor').text(response.color);
        $('#detailProductSize').text('Size: ' + response.size);
        $('#detailProductMaterial').text(response.material);
        $('#detailProductImage').attr('src', response.images[0].image);
        $('#detailProductImageList').html('');
        response.images.forEach(image => {
            $('#detailProductImageList').append('<img src="' + image.image + '" alt="" class="img-fluid mb-3 image-list" onclick="changeProductImage(this)">');
        });
    }

    function changeProductImage(image) {
        $('#detailProductImage').attr('src', image.src);
    }

</script>

@endsection
