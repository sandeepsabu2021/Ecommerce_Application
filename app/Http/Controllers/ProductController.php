<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function product($id = null)   //product page
    {
        if ($id != null) {
            $proData = Product::where('category_id', '=', $id)->orderBy('created_at', 'DESC')->paginate(7);
            $catData = Category::all();
            return view('admin.pages.product.product', ['proData' => $proData, 'catData' => $catData]);
        } else {
            $proData = Product::orderBy('created_at', 'DESC')->paginate(5);
            $catData = Category::all();
            return view('admin.pages.product.product', ['proData' => $proData, 'catData' => $catData]);
        }
    }

    public function addProduct()  //add product page
    {
        $catData = Category::all();
        return view('admin.pages.product.add-product', ['catData' => $catData]);
    }

    public function productValid(Request $req)    // add product validation
    {
        $validateProduct = $req->validate([
            'name' => 'required',
            'desc' => 'required|max:500',
            'catid' => 'required',
            'type'  => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'filenames.*' => 'mimes:jpeg,jpg,png',
        ], [
            'name.required' => "Enter name",

            'desc.required' => "Enter description",
            'desc.max' => "Maximum 500 characters allowed",

            'catid.required' => "Select category",

            'price.required' => "Enter price",

            'image.required' => "Select image",
            'image.mimes' => "Only jpeg, jpg and png files allowed",

            'quantity.required' => "Enter quantity",

            'filenames.mimes' => "Only jpeg, jpg and png files allowed",
        ]);
        if ($validateProduct) {
            $uuid = hexdec(uniqid());
            $pro = new Product();
            $pro->name = $req->name;
            $pro->description = $req->desc;
            $pro->category_id = $req->catid;
            $pro->type = $req->type;
            $pro->code = $uuid;
            $pro->price = $req->price;
            $pro->quantity = $req->quantity;
            $name = time() . "--" . $uuid . '.' . $req->image->extension();
            $pro->thumbnail = $name;

            try {
                $pro->save();
                $req->image->move(public_path('uploads/thumbnails'), $name);
                $id = $pro->id;
                $att = new ProductAttribute();
                $att->product_id = $id;
                $att->category_id = $req->catid;
                $att->price = $req->price;
                $att->quantity = $req->quantity;
                $att->gender = $req->gender;
                if ($req->brand) {
                    $att->brand = $req->brand;
                }
                if ($req->size) {
                    $att->size = $req->size;
                }
                if ($req->color) {
                    $att->color = $req->color;
                }
                $att->save();
                if ($req->filenames) {
                    foreach ($req->filenames as $img) {
                        $name = $id . "--" . rand() . '.' . $img->extension();
                        $image = new ProductImage();
                        $image->image = $name;
                        $image->product_id = $id;
                        $image->save();
                        $img->move(public_path('uploads/products'), $name);
                    }
                }
                return Redirect::to('/product')->with('Success', 'Product added successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Adding product failed - ' . $e->getMessage());
            }
        }
    }

    public function viewProduct($id) // view product page
    {
        $pro = Product::where('id', '=', $id)->first();
        $att = ProductAttribute::where('product_id', '=', $id)->first();
        $catData = Category::all();
        $imgData = ProductImage::where('product_id', '=', $id)->get();
        if ($imgData) {
            return view(
                'admin.pages.product.view-product',
                ['proData' => $pro, 'catData' => $catData, 'attData' => $att, 'images' => $imgData]
            );
        } else {
            return view(
                'admin.pages.product.view-product',
                ['proData' => $pro, 'catData' => $catData, 'attData' => $att]
            );
        }
    }

    public function editProduct($id)  // edit product page
    {

        $pro = Product::where('id', '=', $id)->first();
        $att = ProductAttribute::where('product_id', '=', $id)->first();
        $catData = Category::all();
        $imgData = ProductImage::where('product_id', '=', $id)->get();
        if ($imgData) {
            return view(
                'admin.pages.product.edit-product',
                ['proData' => $pro, 'catData' => $catData, 'attData' => $att, 'images' => $imgData]
            );
        } else {
            return view(
                'admin.pages.product.edit-product',
                ['proData' => $pro, 'catData' => $catData, 'attData' => $att]
            );
        }
    }

    public function delImage(Request $req)  //delete product image
    {
        $id = $req->iid;
        $img = ProductImage::where('id', '=', $id)->first();

        try {
            $imgName = public_path('uploads/products/') . $img->image;
            unlink($imgName);
            $img->delete();
            return "Image deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting image - " . $e->getMessage();
        }
    }

    public function editProValid(Request $req)    // edit product validation
    {
        $validateProduct = $req->validate([
            'name' => 'required',
            'desc' => 'required|max:500',
            'catid' => 'required',
            'type' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
            'filenames.*' => 'mimes:jpeg,jpg,png',
            'pid' => 'required',
        ], [
            'name.required' => "Enter name",

            'desc.required' => "Enter description",
            'desc.max' => "Maximum 500 characters allowed",

            'catid.required' => "Select category",

            'price.required' => "Enter price",

            'quantity.required' => "Enter quantity",

            'image.mimes' => "Only jpeg, jpg and png files allowed",

            'filenames.mimes' => "Only jpeg, jpg and png files allowed",
        ]);
        if ($validateProduct) {
            $id = $req->pid;
            $pro = Product::where('id', '=', $id)->first();
            $pro->name = $req->name;
            $pro->description = $req->desc;
            $pro->type = $req->type;
            $pro->category_id = $req->catid;
            $pro->price = $req->price;
            $pro->quantity = $req->quantity;

            try {
                $pro->save();
                if($req->image){
                    $name = $pro->thumbnail;
                    $req->image->move(public_path('uploads/thumbnails'), $name);
                }
                $att = ProductAttribute::where('product_id', '=', $id)->first();
                $att->category_id = $req->catid;
                $att->price = $req->price;
                $att->quantity = $req->quantity;
                $att->gender = $req->gender;
                if ($req->brand) {
                    $att->brand = $req->brand;
                }
                if ($req->size) {
                    $att->size = $req->size;
                }
                if ($req->color) {
                    $att->color = $req->color;
                }
                $att->save();
                if ($req->filenames) {
                    foreach ($req->filenames as $img) {
                        $name = $id . "--" . rand() . '.' . $img->extension();
                        $image = new ProductImage();
                        $image->image = $name;
                        $image->product_id = $id;
                        $image->save();
                        $img->move(public_path('uploads/products'), $name);
                    }
                }
                return back()->with('Success', 'Product updated successfully');
            } catch (\Illuminate\Database\QueryException $e) {
                return back()->with('Error', 'Updating product failed - ' . $e->getMessage());
            }
        }
    }

    public function delProduct(Request $req)  //delete product
    {
        $id = $req->pid;
        $pro = Product::where('id', '=', $id)->first();
        $att = ProductAttribute::where('product_id', '=', $id)->first();
        $images = ProductImage::where('product_id', '=', $id)->get();

        try {
            $att->delete();
            if ($images) {
                foreach ($images as $img) {
                    $imgName = public_path('uploads/products/') . $img->image;
                    unlink($imgName);
                    $img->delete();
                }
            }
            $img = public_path('uploads/thumbnails/') . $pro->thumbnail;
            unlink($img);
            $pro->delete();
            return "Product deleted successfully";
        } catch (\Illuminate\Database\QueryException $e) {
            return "Error deleting product - " . $e->getMessage();
        }
    }
}
