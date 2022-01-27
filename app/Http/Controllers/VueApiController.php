<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Http\Resources\TaskResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CMS;
use App\Models\Coupon;
use App\Models\OrderDetail;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\UserAddress;
use App\Models\UserOrder;
use Illuminate\Support\Facades\DB;

class VueApiController extends Controller
{
    public function showProduct($id = null)     // display products with filter api
    {
        if ($id == null) {
            $proData = Product::inRandomOrder()->get();
            return response([
                'product' => TaskResource::collection($proData),
            ]);
        } elseif (is_numeric($id)) {
            $proData = Product::where('category_id', '=', $id)->inRandomOrder()->get();
            return response([
                'product' => TaskResource::collection($proData),
            ]);
        } else {
            $brand = $id;
            $proData = Product::whereIn('id', function ($query) use ($brand) {
                $query->select('product_id')
                    ->from((new ProductAttribute())->getTable())
                    ->where("brand", $brand);
            })->inRandomOrder()->get();

            return response([
                'product' => TaskResource::collection($proData),
            ]);
        }
    }

    public function category()      // display category api
    {
        $catData = Category::all();
        return response([
            'category' => TaskResource::collection($catData),
        ]);
    }

    public function profile($id)    // display profile api
    {
        $profile = User::where('email', '=', $id)->first();
        return response([
            'profile' => new TaskResource($profile),
        ], 200);
    }

    public function brand()     // display brands and count api
    {
        $brand = ProductAttribute::select("brand", DB::raw("count(brand) as brand_count"))
            ->groupBy(DB::raw("brand"))
            ->get();

        return response([
            'brand' => TaskResource::collection($brand),
        ]);
    }

    public function feature()   // display featured products api
    {
        $proData = Product::where('type', '=', 1)->inRandomOrder()->limit(6)->get();
        return response([
            'feature' => TaskResource::collection($proData),
        ]);
    }

    public function recommend() // display recommended products api
    {
        $proData = Product::where('type', '=', 2)->inRandomOrder()->limit(6)->get();
        return response([
            'recommend' => TaskResource::collection($proData),
        ]);
    }

    public function banner()    // display banners api
    {
        $banner = Banner::all();
        return response([
            'banner' => TaskResource::collection($banner),
        ]);
    }

    public function product($id)    // display product details api
    {
        $pro = Product::find($id);
        $dets = ProductAttribute::where('product_id', '=', $id)->first();
        $images = ProductImage::where('product_id', '=', $id)->get();
        return response([
            'product' => new TaskResource($pro),
            'details' => new TaskResource($dets),
            'images' => new TaskResource($images),
        ], 200);
    }

    public function coupon($id)     // check coupon api
    {
        $cop = Coupon::where('code', '=', $id)->first();
        if ($cop) {
            return response([
                'coupon' => new TaskResource($cop),
                'err' => 0
            ]);
        } else {
            return response([
                'err' => 1,
                'msg' => 'Coupon code invalid'
            ]);
        }
    }



    public function cms($id = null)     // display cms api
    {
        if ($id != null) {
            $cms = CMS::where('url', '=', $id)->first();
            return response([
                'cms' => new TaskResource($cms),
            ], 200);
        } else {
            $cms = CMS::all();
            return response([
                'cms' => TaskResource::collection($cms),
            ], 200);
        }
    }

    public function order($id)      // display customer order details api
    {
        $user = User::where('email', '=', $id)->first();
        $uid = $user->id;
        $order = UserOrder::where('user_id', '=', $uid)->orderBy('created_at', 'DESC')->get();
        $address = UserAddress::where('user_id', '=', $uid)->get();
        $details = collect();
        $products = collect();
        foreach ($order as $ord) {
            $detail = OrderDetail::where('order_id', '=', $ord->id)->get();
            $details->push($detail);

            foreach ($detail as $d) {
                $product = Product::where('id', '=', $d->product_id)->get();
                $products->push($product);
            }
        }

        $coupon = Coupon::all();

        $details = $details->flatten();
        $products = $products->flatten();

        return response([
            'ord' => TaskResource::collection([
                'order' => $order, 
                'details' => $details, 
                'product' => $products,
                'address' => $address, 
                'coupon' => $coupon]),
        ], 200);
    }
}
