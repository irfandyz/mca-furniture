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
            <div class="row">
                @foreach ($products as $product)
                <div class="col-sm-4 mt-3">
                    <div class="card hover-shadow" data-aos="fade-up" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <a href="{{ asset('storage/products/' . $product->image) }}" data-lightbox="product" data-title="{{ $product->name }}">
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="object-fit: cover; border-radius: 20px 20px 0 0;">
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
