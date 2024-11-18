@section('css')

@endsection
<div class="row p-5">
    <div class="col-md-9">
        <div class="container">
            <form action="{{ asset('collection') }}" method="get" class="mb-4">
                <div class="input-group input-group-merge speech-to-text bg-white w-100 hover-shadow">
                    <input type="text" name="keyword" class="form-control" placeholder="Search"
                        value="{{ Request::get('keyword') }}" aria-describedby="text-to-speech-addon">
                    <button type="submit" class="btn btn-primary btn-main" style="margin-left: 10px;">
                        <i class='fas fa-magnifying-glass'></i>
                    </button>
                </div>
            </form>
            <div class="row mb-5">
                @foreach ($products as $product)
                <div class="col-sm-4 mt-3">
                    <div class="card hover-shadow" data-aos="fade-up" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" data-bs-toggle="modal" onclick="getProductDetail('{{ $product->id }}')" data-bs-target="#productDetail">
                        <a data-lightbox="product" data-title="{{ $product->name }}">
                            <img src="{{ asset('products/' . $product->images[0]->image) }}" alt="{{ $product->name }}" class="card-img-top" style="object-fit: cover; border-radius: 20px 20px 0 0;">
                        </a>
                        <div class="card-body text-center" style="padding: 20px;">
                            <h5 class="card-title" style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 18px; color: #4F2B00;">{{ $product->name }}</h5>
                            @if($product->category)
                                <span class="text-primary" style="font-size: 12px; font-weight: bold;">{{ $product->category->name }}</span>
                            @else
                                <span class="text-primary" style="font-size: 12px; font-weight: bold;">uncategorized</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                @if($products->isEmpty())
                    <div class="col-12 text-center">
                        <h5 class="text-muted">No products found</h5>
                    </div>
                @endif

                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>

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
                                        <img src="" alt="" id="productImage" class="w-100 mb-3 border-image rounded">
                                        <div class="list-image-container">
                                            <div class="list-image-inner d-flex overflow-x-auto" id="productImageList">
                                                <img src="{{ asset('products/1.png') }}" alt="" id="productImage" class="img-fluid image-list">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 p-5">
                                        <div class="mb-3">
                                            <h3>
                                                <span id="productName" class="fw-bold text-uppercase"></span>
                                            </h3>
                                            <h5 id="productCode" class="fw-bold text-info"></h5>
                                            <small id="productCategory" class="text-warning mt-3 text-uppercase fw-bold"></small>
                                        </div>
                                        <span class="badge bg-primary" style="font-size: 12px;">
                                            Width : <span id="detailProductSizeWidth"></span> cm
                                        </span>
                                        <span class="badge bg-primary" style="font-size: 12px;">
                                            Length : <span id="detailProductSizeLength"></span> cm
                                        </span>
                                        <span class="badge bg-primary" style="font-size: 12px;">
                                            Height : <span id="detailProductSizeHeight"></span> cm
                                        </span>
                                        <div class="mt-5">
                                            <span class="fw-bold">Color :</span> <span id="productColor" class="text-muted"></span>
                                        </div>
                                        <div class="mt-5">
                                            <span class="fw-bold">Material :</span> <span id="productMaterial" class="text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="">
            <div class="filter-container">
                <h5 style="font-size: 16px" class="fw-bold text-center">Category</h5>
                <div style="max-height: 400px; overflow-y: auto;">
                    <form action="{{ asset('collection') }}" method="get">
                        @foreach ($categories as $category)
                            <div class="form-check d-flex justify-content-between">
                                <div>
                                    <input class="form-check-input" type="checkbox" name="filter_category[]" value="{{ $category->id }}"
                                        id="{{ $category->name }}" @if(request()->has('filter_category') && in_array($category->id, request('filter_category'))) checked @endif>
                                    <label class="form-check-label"
                                        for="{{ $category->name }}">{{ $category->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary btn-main mt-3 w-100">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')

<script>

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
        $('#productName').text(response.name.charAt(0).toUpperCase() + response.name.slice(1));
        $('#productCode').text(response.code);
        $('#productCategory').text(response.category.name.charAt(0).toUpperCase() + response.category.name.slice(1));
        $('#productColor').text(response.color.charAt(0).toUpperCase() + response.color.slice(1));
        $('#detailProductSizeHeight').text(response.size_height);
        $('#detailProductSizeWidth').text(response.size_width);
        $('#detailProductSizeLength').text(response.size_length);
        $('#productMaterial').text(response.material.charAt(0).toUpperCase() + response.material.slice(1));
        $('#productImage').attr('src', response.images[0].image);
        $('#productImageList').html('');
        response.images.forEach(image => {
            $('#productImageList').append('<img src="' + image.image + '" alt="" class="img-fluid image-list mb-3" onclick="changeProductImage(this)">');
        });
    }

    function changeProductImage(image) {
        $('#productImage').attr('src', image.src);
    }
</script>

@endsection
