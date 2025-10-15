<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
      return view('products.index',compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('products.create',compact('categories'));
    }
     public function show(Product $product)
    {
      return view('products.show',compact('product'));
    }
 public function store(Request $request)
    {
        $request->validate([
    'primary_image'     => 'required|image',
    'name'              => 'required|string',
    'category_id'       => 'required|integer',
    'description'       => 'required|string',
    'price'             => 'required|integer',
    'status'            => 'required|integer',
    'quantity'          => 'required|integer',
    'sale_price'        => 'nullable|integer',
    'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
    'date_on_sale_to'   => 'nullable|date_format:Y/m/d H:i:s',
    'images.*'          => 'nullable|image',
]);
   $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
      $request->primary_image->storeAs('images/products/',$primaryImageName);
        if($request->has('images') && $request->images !== null)
        {
            $fileNameImages = [];
            foreach($request->images as $image)
            {
                 $fileNameImage = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                 $image->storeAs('images/products/',$fileNameImage);
                 array_push( $fileNameImages,$fileNameImage);
        }
    }
        DB::beginTransaction();
        $product = Product::create([
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name),
            'category_id' => $request->category_id,
            'primary_image' => $primaryImageName,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->filled('sale_price') ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null,
        ]);
      if($request->has('images') && $request->images !== null){
        foreach($fileNameImages as $fileNameImage)
        {
        ProductImage::create([
            'product_id' => $product->id,
            'image' => $fileNameImage
        ]);
        }
    }
     DB::commit();
    return redirect()->route('product.index')->with('success' ,'محصول با موفقیت ایجاد شد');
    }
public function makeSlug($string)
{
$slug = make_slug($string);
$count = Product::whereraW("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
$result = $count ? "{$slug}-{$count}" : $slug;
return $result;
}
public function edit(Product $product)
{
     $categories = Category::all();
        return view('products.edit',compact('categories','product'));
}
public function update(Request $request, Product $product)
{
    // ولیدیشن
    $request->validate([
        'primary_image' => 'nullable|image',
        'name' => 'required|string',
        'category_id' => 'required|integer',
        'description' => 'required',
        'price' => 'required|integer',
        'status' => 'required|integer',
        'quantity' => 'required|integer',
        'sale_price' => 'nullable|integer',
        'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
        'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
        'images.*' => 'nullable|image'
    ]);

    // مدیریت تصویر اصلی
    $primaryImageName = $product->primary_image; // پیش‌فرض تصویر قبلی
    if ($request->hasFile('primary_image')) {
        // حذف تصویر قبلی
        if ($product->primary_image && Storage::exists('images/products/' . $product->primary_image)) {
            Storage::delete('images/products/' . $product->primary_image);
        }

        // ذخیره تصویر جدید
        $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
        $request->primary_image->storeAs('images/products/', $primaryImageName);
    }

    // مدیریت تصاویر چندگانه
    $fileNameImages = [];
    if ($request->hasFile('images')) {
        // حذف تصاویر قبلی
        foreach ($product->images as $image) {
            if (Storage::exists('images/products/' . $image->image)) {
                Storage::delete('images/products/' . $image->image);
            }
            $image->delete();
        }

        // ذخیره تصاویر جدید
        foreach ($request->file('images') as $image) {
            $fileNameImage = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
            $image->storeAs('images/products/', $fileNameImage);
            $fileNameImages[] = $fileNameImage;
        }
    }

    // تراکنش برای آپدیت محصول
    DB::beginTransaction();
    try {
        $product->update([
            'name' => $request->name,
            'slug' => $request->name != $product->name ? $this->makeSlug($request->name) : $product->slug,
            'category_id' => $request->category_id,
            'primary_image' => $primaryImageName,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price ?? 0,
            'date_on_sale_from' => $request->date_on_sale_from ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to ? getMiladiDate($request->date_on_sale_to) : null,
        ]);

        // ذخیره تصاویر چندگانه جدید در جدول ProductImage
        foreach ($fileNameImages as $fileNameImage) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $fileNameImage
            ]);
        }

        DB::commit();
        return redirect()->route('product.index')->with('success', 'محصول با موفقیت ویرایش شد');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'خطایی در ویرایش محصول رخ داد: ' . $e->getMessage());
    }
}

 public function destroy(Product $product)
    {
        $product->delete();
      return redirect()->route('product.index')->with('warning' , 'محصول با موفقیت حذف شد');
    }

}
