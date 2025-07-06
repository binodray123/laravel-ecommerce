<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                          sum(if(status='ordered',total,0)) As TotalOrderedAmount,
                          sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
                          sum(if(status='canceled',total,0)) As TotalCanceledAmount,
                          Count(*) As Total,
                          sum(if(status='ordered',1,0)) As TotalOrdered,
                          sum(if(status='delivered',1,0)) As TotalDelivered,
                          sum(if(status='canceled',1,0)) As TotalCanceled
                           From Orders");

        $monthlyDatas = DB::select("
                           SELECT
                               M.id AS MonthNo,
                               M.name AS MonthName,
                               IFNULL(D.TotalAmount, 0) AS TotalAmount,
                               IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
                               IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                               IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
                           FROM
                               month_names M
                           LEFT JOIN (
                               SELECT
                                   DATE_FORMAT(created_at, '%b') AS MonthName,
                                   MONTH(created_at) AS MonthNo,
                                   SUM(total) AS TotalAmount,
                                   SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                                   SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                                   SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount
                               FROM
                                   orders
                               WHERE
                                   YEAR(created_at) = YEAR(NOW())
                               GROUP BY
                                   YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                               ORDER BY
                                   MONTH(created_at)
                           ) D ON D.MonthNo = M.id
                       ");
        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'AmountM',
            'OrderedAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
        ));
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateBrandThumbnailsImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been added successfully!');
    }

    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:brands,slug,' . $request->id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Find the existing brand
        $brand = Brand::find($request->id);

        if (!$brand) {
            return redirect()->route('admin.brands')->with('error', 'Brand not found!');
        }

        // Update brand details
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($brand->image && File::exists(public_path('uploads/brands/' . $brand->image))) {
                File::delete(public_path('uploads/brands/' . $brand->image));
            }

            // Process the new image
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();

            // Save the image and generate thumbnails
            $this->GenerateBrandThumbnailsImage($image, $file_name);

            $brand->image = $file_name;
        }

        // Save the brand
        $brand->save();

        // Redirect back with success message
        return redirect()->route('admin.brands')->with('status', 'Brand has been updated successfully!');
    }

    public function GenerateBrandThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');
        $img = Image::make($image->path());
        $img->resize(124, 124);
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function brand_delete($id)
    {
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands') . '/' . $brand->image)) {
            File::delete(public_path('uploads/brands') . '/' . $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand has been deleted successfully!');
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateCategoryThumbnailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully!');
    }
    public function GenerateCategoryThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::make($image->path());
        $img->resize(124, 124);
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $request->id,
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Find the existing category
        $category = Category::find($request->id);

        if (!$category) {
            return redirect()->route('admin.categories')->with('error', 'Category not found!');
        }

        // Update category details
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($category->image && File::exists(public_path('uploads/categories/' . $category->image))) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }

            // Process the new image
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();

            // Save the image and generate thumbnails
            $this->GenerateCategoryThumbnailsImage($image, $file_name);

            $category->image = $file_name;
        }

        // Save the category
        $category->save();

        // Redirect back with success message
        return redirect()->route('admin.categories')->with('status', 'Category has been updated successfully!');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully!');
    }

    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }


    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug ?: Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        // Handle main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Handle gallery images
        $product->images = collect($request->file('images', []))
            ->map(function ($file, $index) use ($current_timestamp) {
                $extension = $file->getClientOriginalExtension();
                $allowedExtensions = ['jpg', 'png', 'jpeg'];

                if (in_array($extension, $allowedExtensions)) {
                    $fileName = $current_timestamp . '_' . $index . '.' . $extension;
                    $this->GenerateProductThumbnailImage($file, $fileName);
                    return $fileName;
                }
                return null;
            })
            ->filter()
            ->implode(',');

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');
    }

    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $destinationPathThumbnails = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');
        $img = Image::make($image->path());
        $img->resize(540, 689);
        $img->resize(540, 689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);

        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnails . '/' . $imageName);
    }

    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required|boolean',
            'quantity' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::findOrFail($request->id);
        $product->name = $request->name;
        $product->slug = $request->slug ?: Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;
        $uploadPath = public_path('uploads/products');

        // Ensure the upload directory exists
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        // Handle main image
        if ($request->hasFile('image')) {
            if ($product->image && File::exists($uploadPath . '/' . $product->image)) {
                File::delete($uploadPath . '/' . $product->image);
            }

            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        // Handle gallery images
        if ($request->hasFile('images')) {
            // Delete existing gallery images
            if ($product->images) {
                foreach (explode(',', $product->images) as $existingImage) {
                    if (File::exists($uploadPath . '/' . $existingImage)) {
                        File::delete($uploadPath . '/' . $existingImage);
                    }
                }
            }

            $galleryImages = $request->file('images');
            $galleryFileNames = [];

            foreach ($galleryImages as $index => $file) {
                if (in_array($file->extension(), ['jpg', 'png', 'jpeg'])) {
                    $fileName = $current_timestamp . '_' . $index . '.' . $file->extension();
                    $this->GenerateProductThumbnailImage($file, $fileName);
                    $galleryFileNames[] = $fileName;
                }
            }

            $product->images = implode(',', $galleryFileNames);
        }

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Product has been updated successfully!');
    }

    public function product_delete($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        $uploadPath = public_path('uploads/products');

        // Delete the main product image if it exists
        if ($product->image && File::exists($uploadPath . '/' . $product->image)) {
            File::delete($uploadPath . '/' . $product->image);
        }

        // Delete the gallery images if they exist
        if ($product->images) {
            $galleryImages = explode(',', $product->images);
            foreach ($galleryImages as $image) {
                if (File::exists($uploadPath . '/' . $image)) {
                    File::delete($uploadPath . '/' . $image);
                }
            }
        }

        // Delete the product from the database
        $product->delete();

        // Redirect with a success message
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view('admin.coupons', compact('coupons'));
    }

    public function coupon_add()
    {
        return view('admin.coupon-add');
    }

    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been added successfully!');
    }

    public function coupon_edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function coupon_update(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been updated successfully!');
    }

    public function coupon_delete($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order-details', compact('order', 'orderItems', 'transaction'));
    }

    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;

        switch ($request->order_status) {
            case 'shipped':
                $order->shipped_date = Carbon::now();
                break;
            case 'out_for_delivery':
                $order->out_for_delivery_date = Carbon::now();
                break;
            case 'delivered':
                $order->delivered_date = Carbon::now();
                break;
            case 'canceled':
                $order->canceled_date = Carbon::now();
                break;
        }
        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        return back()->with("status", "Status changed successfully!");
    }

    public function slides()
    {
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slides', compact('slides'));
    }

    public function slide_add()
    {
        return view('admin.slide-add');
    }

    public function slide_store(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);
        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateSlideThumbnailsImage($image, $file_name);
        $slide->image = $file_name;

        $slide->save();
        return redirect()->route('admin.slides')->with('status', 'Slide has been added successfully!');
    }

    public function GenerateSlideThumbnailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/slides');
        $img = Image::make($image->path());
        $img->resize(400, 690);
        $img->resize(400, 690, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }

    public function slide_edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide-edit', compact('slide'));
    }

    public function slide_update(Request $request)
    {
        $request->validate([
            'tagline' => 'required',
            'title' => 'required',
            'subtitle' => 'required',
            'link' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);
        $slide = Slide::find($request->id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
                File::delete(public_path('uploads/slides') . '/' . $slide->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateSlideThumbnailsImage($image, $file_name);
            $slide->image = $file_name;
        }

        $slide->save();
        return redirect()->route('admin.slides')->with('status', 'Slide has been updated successfully!');
    }

    public function slide_delete($id)
    {
        $slide = Slide::find($id);
        if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
            File::delete(public_path('uploads/slides') . '/' . $slide->image);
        }
        $slide->delete();
        return redirect()->route('admin.slides')->with("status", "Slide has been deleted successfully!");
    }

    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status', 'Contact deleted successfully!');
    } // End Method

    // Order Tracking Method Start From Here....
    public function index1()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $scans = $order->scans()->orderBy('scan_time', 'desc')->get();
        return view('admin.orders.track', compact('order', 'scans'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'scan_time' => 'required|date',
        ]);

        // Insert tracking scan
        $order->scans()->create([
            'status' => $request->status,
            'location' => $request->location,
            'state' => $request->state,
            'scan_time' => $request->scan_time,
        ]);

        // Update order status
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save(); // OR: $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Tracking update added.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }
    //End Method
}
