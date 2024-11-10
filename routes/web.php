<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Models\Category;
use App\Models\Image;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('index');
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
        $image->image = asset('storage/products/' . $image->image);
    }
    return response()->json($product);
});

Route::post('/contact', function (Request $request) {
    Message::create($request->all());
    return redirect()->back();
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
            'image' => 'required',
            'size' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $images = $request->file('image');
        $imageData = [];
        foreach ($images as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('products', $imageName, 'public');
            $imageData[] = $imageName;
        }
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'size' => $request->size,
            'color' => $request->color,
            'material' => $request->material,
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
            if (Storage::disk('public')->exists('products/' . $image->image)) {
                Storage::disk('public')->delete('products/' . $image->image);
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
        $image->delete();
        if (Storage::disk('public')->exists('products/' . $image->image)) {
            Storage::disk('public')->delete('products/' . $image->image);
        }
        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    });

    Route::post('/admin/product/update', function (Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'image' => 'nullable',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'size' => 'required|string|max:255',
        ]);

        $product = Product::find($request->id);
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'color' => $request->color,
            'material' => $request->material,
            'size' => $request->size,
        ]);

        if ($request->hasFile('image')) {
            $countImage = is_array($request->file('image')) ? count($request->file('image')) : 0;
            $countImageExisting = Image::where('product_id', $product->id)->count();
            if ($countImage + $countImageExisting > 4) {
                return redirect()->back()->with('error', 'Max 4 Image');
            }
            foreach ($request->file('image') as $image) {
                $imageName = time() . rand(1111, 9999) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('products', $imageName, 'public');
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

});
