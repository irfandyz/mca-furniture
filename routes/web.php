<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Models\Category;
use App\Models\Image;
use App\Models\Message;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\MediaNews;
use App\Models\News;
use App\Models\User;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/', function () {
    $sliders = Slider::all();
    return view('index', compact('sliders'));
});
Route::get('/collection', function () {
    $products = Product::paginate(9);
    $categories = Category::all();
    if (request()->get('keyword')) {
        $products = Product::where('name', 'like', '%' . request()->get('keyword') . '%')->paginate(9);
    }
    if (request()->get('filter_category')) {
        $products = Product::whereHas('category', function ($query) {
            $query->whereIn('categories.id', request()->get('filter_category'));
        })->paginate(9);
    }
    return view('collection.index', compact('products', 'categories'));
});

Route::get('/collection/product/{id}', function ($id) {
    $product = Product::with('category', 'images')->find($id);
    $product->imageCount = $product->images->count();
    foreach ($product->images as $image) {
        $image->image = asset('products/' . $image->image);
    }
    return response()->json($product);
});

Route::post('/contact', function (Request $request) {
    Message::create($request->all());
    return redirect()->back();
});

Route::get('/news/{id}', function ($id) {
    $news = News::find($id);
    return view('detail-news', compact('news'));
});

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/admin/logout', function () {
    Auth::logout();
    return redirect('/login');
});
Route::post('/login/auth', function (Request $request) {
    if (Auth::attempt($request->only('email', 'password'))) {
        return redirect('/admin');
    }
    return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
});

Route::middleware(AuthMiddleware::class)->group(function () {

    // User
    Route::middleware(SuperAdminMiddleware::class)->group(function () {
        Route::get('/admin/user', function (request $request) {
            $users = User::paginate(10);
            $keyword = request()->get('keyword');
            if ($keyword) {
                $users = User::where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->paginate(10);
            }
            return view('admin.user', compact('users'));
        });

        Route::post('/admin/user/store', function (Request $request) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:admin,superadmin',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
            return redirect()->back();
        });

        Route::delete('/admin/user/delete/{id}', function ($id) {
            $user = User::find($id);
            $user->delete();
            return redirect()->back();
        });
        Route::get('/admin/user/{id}', function ($id) {
            $user = User::find($id);
            if (!$user) {
                abort(404);
            }
            return response()->json($user);
        });

        Route::put('/admin/user/update', function (Request $request) {
            $request->validate([
                'id' => 'required|integer|exists:users,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'password' => 'nullable|string|min:8',
                'role' => 'required|string|in:admin,superadmin',
            ]);

            $user = User::find($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'role' => $request->role,
            ]);
            return redirect()->back();
        });
    });

    // Message
    Route::get('/admin/message', function (request $request) {
        $messages = Message::paginate(10);
        if ($keyword = request()->get('keyword')) {
            $messages = Message::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                ->orWhere('phone', 'like', '%' . $keyword . '%')
                ->orWhere('message', 'like', '%' . $keyword . '%')
                ->paginate(10);
        }
        return view('admin.message', compact('messages'));
    });

    Route::delete('/admin/message/delete/{id}', function ($id) {
        $message = Message::find($id);
        $message->delete();
        return redirect()->back();
    });

    // Product
    Route::get('/admin', function (request $request) {
        $categories = Category::all();
        $products = Product::paginate(8);

        $keyword = request()->get('keyword');
        if ($keyword) {
            $products = Product::where('name', 'like', '%' . $keyword . '%')->paginate(8);
        }

        $filterCategories = $request->filter_category;
        if ($filterCategories) {
            $products = Product::whereHas('category', function ($query) use ($filterCategories) {
                $query->whereIn('categories.id', $filterCategories);
            })->paginate(8);
        }

        return view('admin.index', compact('categories', 'products'));
    });

    Route::post('/admin/product/store', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'code' => 'required|string|max:255',
            'image' => 'required',
            'color' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'size_height_cm' => 'required|numeric',
            'size_width_cm' => 'required|numeric',
            'size_length_cm' => 'required|numeric',
            'size_height_inch' => 'required|numeric',
            'size_width_inch' => 'required|numeric',
            'size_length_inch' => 'required|numeric',
        ]);
        $images = $request->file('image');
        $imageData = [];
        foreach ($images as $key => $image) {
            $imageName = time() . $key . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('products'), $imageName);
            $imageData[] = $imageName;
        }
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'code' => $request->code,
            'color' => $request->color,
            'material' => $request->material,
            'size_height_cm' => $request->size_height_cm,
            'size_width_cm' => $request->size_width_cm,
            'size_length_cm' => $request->size_length_cm,
            'size_height_inch' => $request->size_height_inch,
            'size_width_inch' => $request->size_width_inch,
            'size_length_inch' => $request->size_length_inch,
        ]);
        foreach ($imageData as $image) {
            Image::create([
                'product_id' => $product->id,
                'image' => $image,
            ]);
        }
        return redirect()->back();
    });

    Route::get('/admin/product/delete/{id}', function ($id) {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->withErrors(['success' => false, 'message' => 'Product not found']);
        }
        foreach ($product->images as $image) {
            if (file_exists(public_path('products/' . $image->image))) {
                unlink(public_path('products/' . $image->image));
            }
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');
    });

    Route::get('/admin/product/image/delete/{id}', function ($id) {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }
        $countImage = Image::where('product_id', $image->product_id)->count();
        if ($countImage == 1) {
            return response()->json(['success' => false, 'message' => 'Product must have at least 1 image']);
        }
        if (file_exists(public_path('products/' . $image->image))) {
            unlink(public_path('products/' . $image->image));
        }
        $image->delete();
        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    });

    Route::post('/admin/product/update', function (Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'size_height_cm' => 'required|numeric',
            'size_width_cm' => 'required|numeric',
            'size_length_cm' => 'required|numeric',
            'size_height_inch' => 'required|numeric',
            'size_width_inch' => 'required|numeric',
            'size_length_inch' => 'required|numeric',
        ]);

        $product = Product::find($request->id);
        $product->update([
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'color' => $request->color,
            'material' => $request->material,
            'size_height_cm' => $request->size_height_cm,
            'size_width_cm' => $request->size_width_cm,
            'size_length_cm' => $request->size_length_cm,
            'size_height_inch' => $request->size_height_inch,
            'size_width_inch' => $request->size_width_inch,
            'size_length_inch' => $request->size_length_inch,
        ]);

        if ($request->hasFile('image')) {
            $countImage = is_array($request->file('image')) ? count($request->file('image')) : 0;
            $countImageExisting = Image::where('product_id', $product->id)->count();
            if ($countImage + $countImageExisting > 4) {
                return redirect()->back()->with('error', 'Max 4 Image');
            }
            foreach ($request->file('image') as $image) {
                $imageName = time() . rand(1111, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('products'), $imageName);
                Image::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
        }

        $product->save();
        return redirect()->back();
    });

    Route::get('/admin/product/{id}', function ($id) {
        $product = Product::find($id);
        return response()->json($product);
    });

    // Category

    Route::get('/admin/category/delete/{id}', function ($id) {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back();
    });

    Route::post('/admin/category/store', function (Request $request) {
        Category::create([
            'name' => $request->name,
        ]);
        return redirect()->back();
    });

    Route::post('/admin/category/update', function (Request $request) {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
        return redirect()->back();
    });

    // Slider

    Route::get('/admin/slider', function (request $request) {
        $sliders = Slider::paginate(5);
        return view('admin.slider', compact('sliders'));
    });

    Route::post('/admin/slider/store', function (Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (Slider::count() >= 4) {
            return redirect()->back()->with('error', 'Max 4 Slider');
        }

        $imageName = time() . rand(1111, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('sliders'), $imageName);
        Slider::create([
            'image' => $imageName,
        ]);
        return redirect()->back();
    });

    Route::post('/admin/slider/update', function (Request $request) {
        $slider = Slider::find($request->id);

        if ($request->hasFile('image')) {
            if (file_exists(public_path('sliders/' . $slider->image))) {
                unlink(public_path('sliders/' . $slider->image));
            }
            $imageName = time() . rand(1111, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('sliders'), $imageName);
            $slider->image = $imageName;
        }
        $slider->save();
        return redirect()->back();
    });

    Route::get('/admin/slider/{id}', function ($id) {
        $slider = Slider::find($id);
        if (file_exists(public_path('sliders/' . $slider->image))) {
            unlink(public_path('sliders/' . $slider->image));
        }
        $slider->delete();
        return redirect()->back()->with('success', 'Slider deleted successfully');
    });

    // Setting

    Route::get('/admin/setting', function (request $request) {
        $settings = Setting::first();
        return view('admin.setting', compact('settings'));
    });

    Route::post('/admin/setting/update', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_author' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'map' => 'nullable|string',
        ]);
        $setting = Setting::first();
        if ($request->hasFile('logo')) {
            if (file_exists(public_path('logos/' . $setting->logo))) {
                unlink(public_path('logos/' . $setting->logo));
            }
            $imageName = time() . rand(1111, 9999) . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('logos'), $imageName);
            $setting->logo = $imageName;
        }
        $setting->update([
            'title' => $request->title,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'meta_description' => $request->meta_description,
            'meta_author' => $request->meta_author,
            'copyright' => $request->copyright,
            'map' => $request->map,
            'logo' => $setting->logo,
        ]);
        return redirect()->back()->with('success', 'Setting updated successfully');
    });

    // News

    Route::get('/admin/news', function (request $request) {
        $news = News::orderBy('id', 'desc')->paginate(5);
        return view('admin.news', compact('news'));
    });

    Route::post('/admin/news/store', function (Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);
        if (News::count() >= 5) {
            return redirect()->back()->with('error', 'Max 5 News');
        }

        $imageName = time() . rand(1111, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('news'), $imageName);
        News::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $imageName,
            'date' => $request->date,
            'month' => $request->month,
            'year' => $request->year,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'News created successfully');
    });

    Route::get('/admin/news/{id}', function ($id) {
        $news = News::find($id);
        if (!$news) {
            abort(404);
        }
        if (file_exists(public_path('news/' . $news->image))) {
            unlink(public_path('news/' . $news->image));
        }
        $news->delete();

        return redirect()->back()->with('success', 'News deleted successfully');
    });

    Route::get('/admin/news/get/{id}', function ($id) {
        $news = News::find($id);
        return response()->json($news);
    });

    Route::post('/admin/news/update', function (Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:news,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|string|max:255',
            'month' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $news = News::find($request->id);
        if ($request->hasFile('image')) {
            if (file_exists(public_path('news/' . $news->image))) {
                unlink(public_path('news/' . $news->image));
            }
            $imageName = time() . rand(1111, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('news'), $imageName);
        }
        $news->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $imageName,
            'date' => $request->date,
            'month' => $request->month,
            'year' => $request->year,
        ]);
        return redirect()->back()->with('success', 'News updated successfully');
    });

    Route::post('/admin/news/upload-media', function (Request $request) {
        if ($request->hasFile('file')) {
            $imageName = time() . rand(1111, 9999) . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(public_path('news/content'), $imageName);
            MediaNews::create([
                'media' => $imageName,
                'type' => 'video/image',
            ]);
            return response()->json(['fileName' => $imageName, 'uploaded' => 1, 'link' => asset('news/content/' . $imageName)]);
        } else {
            return response()->json(['fileName' => '', 'uploaded' => 0, 'link' => '']);
        }
    });

    // FAQ

    Route::get('/admin/faq', function (request $request) {
        $faqs = Faq::paginate(5);
        if ($request->keyword) {
            $faqs = Faq::where('question', 'like', '%' . $request->keyword . '%')->orWhere('answer', 'like', '%' . $request->keyword . '%')->paginate(5);
        }
        return view('admin.faq', compact('faqs'));
    });

    Route::post('/admin/faq/store', function (Request $request) {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->back()->with('success', 'FAQ created successfully');
    });

    Route::get('/admin/faq/delete/{id}', function ($id) {
        $faq = Faq::find($id);
        $faq->delete();
        return redirect()->back()->with('success', 'FAQ deleted successfully');
    });

    Route::post('/admin/faq/update', function (Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:faqs,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        $faq = Faq::find($request->id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->back()->with('success', 'FAQ updated successfully');
    });

});
