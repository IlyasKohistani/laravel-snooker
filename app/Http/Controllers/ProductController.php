<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission =  $this->get_user_permission();
        //
        if (!in_array('viewProduct', $permission)) {
            return redirect('/home');
        }


        return view('products.index')->with('user_permission', $permission);
    }


    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
    public function fetchData()
    {
        $permission =  $this->get_user_permission();
        if (!in_array('viewProduct', $permission)) {
            return redirect('/home');
        }

        $result = array('data' => array());

        $data = Product::with('stores')->get();

        foreach ($data as $key => $value) {
            $store = $value->stores;
            $store_name = array();

            $store_name = implode(', ', $store->pluck('name')->all());


            // button
            $buttons = '';
            if (in_array('updateProduct', $permission)) {
                $buttons .= '<a href="' . 'product/' . $value['id'] . '/edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if (in_array('deleteProduct', $permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }


            $img = '<img src="' . asset('images/products/' . $value->image . '') . '" alt="' . $value['name'] . '" class="img-circle" width="50" height="50" />';

            $availability = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $img,
                $value['name'],
                $value['price'],
                $store_name,
                $availability,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // foreach (Product::find(8)->stores as $store) {
        //     dd($store->pivot->store_id);
        // }


        $category = Category::where('active', '1')->get();
        $stores = Store::where('active', '1')->get();

        return view('products.create')->with('stores', $stores)->with('category', $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!in_array('createProduct', $this->get_user_permission())) {
            return redirect('/home');
        }

        $this->validate(
            $request,
            [
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'product_name' => 'required|unique:products,name',
                'price' => 'required|numeric',
                'description' => 'nullable',
                'category' => 'required',
                'store' => 'required',
                'is_game' => 'required|boolean',
                'active' => 'required|in:1,2',
            ]
        );

        $category = Category::find($request['category']);
        $store = Store::find($request['store']);
        if (request()->hasFile('product_image')) {

            $imageName = time() . '.' . $request->file('product_image')->getClientOriginalExtension();

            $request->file('product_image')->move(public_path('images/products/'), $imageName);

            $product = new Product();

            $product->name = $request['product_name'];
            $product->price = $request['price'];
            $product->image = $imageName;
            $product->description = $request['description'];
            $product->active = $request['active'];
            $product->is_game = $request['is_game'];
            $save = $product->save();
            $product->categories()->attach($category);
            $product->stores()->attach($store);

            if ($save) {
                session()->flash('success', 'Product created successfully.');
                return redirect('product');
            } else {
                session()->flash('errors', 'Error occurred!!');
                return redirect('product');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!$product) {
            return redirect('/home');
        }
        //load if the categories and stores hav not been loaded as eager loading
        $product->loadMissing(['stores', 'categories']);


        if (!in_array('updateProduct', $this->get_user_permission())) {
            return  redirect('/home');
        }

        //categories and stores ids
        $category_data = $product->categories->pluck('id')->all();
        $store_data = $product->stores->pluck('id')->all();
        $category = Category::where('active', '1')->get();
        $stores = Store::where('active', '1')->get();

        $data = [
            'product_data' => $product,
            'category' => $category,
            'stores' => $stores,
            'category_data' => $category_data,
            'store_data' => $store_data
        ];

        return view('products.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (!in_array('updateProduct', $this->get_user_permission())) {
            return  redirect('/home');
        }
        $this->validate(
            $request,
            [
                'product_name' => 'required|unique:products,name,' . $product['id'] . ',id',
                'price' => 'required|numeric',
                'description' => 'nullable',
                'category' => 'required',
                'store' => 'required',
                'is_game' => 'required|boolean',
                'active' => 'required|in:1,2',
            ]
        );

        $category = Category::find($request['category']);
        $store = Store::find($request['store']);
        if (request()->hasfile('product_image')) {
            $this->validate(
                $request,
                [
                    'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2548'
                ]
            );
            $path =  public_path() . '/images/products/' . $product['image'];
            if (File::exists($path)) {
                File::delete($path);
            }

            $imageName = time() . '.' . $request->file('product_image')->getClientOriginalExtension();
            $request->file('product_image')->move(public_path('images/products/'), $imageName);

            $product->name = $request['product_name'];
            $product->price = $request['price'];
            $product->image = $imageName;
            $product->description = $request['description'];
            $product->active = $request['active'];
            $product->is_game = $request['is_game'];
            $save = $product->save();
            $product->categories()->sync($category);
            $product->stores()->sync($store);

            if ($save) {
                session()->flash('success', 'Product updated successfully.');
                return redirect('product');
            } else {
                session()->flash('errors', 'Error occurred!!');
                return redirect('product');
            }
        } else {
            $product->name = $request['product_name'];
            $product->price = $request['price'];
            $product->description = $request['description'];
            $product->active = $request['active'];
            $product->is_game = $request['is_game'];
            $save = $product->save();
            $product->categories()->sync($category);
            $product->stores()->sync($store);

            if ($save) {
                session()->flash('success', 'Product updated successfully.');
                return redirect('product');
            } else {
                session()->flash('errors', 'Error occurred!!');
                return redirect('product');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        if (!in_array('deleteProduct', $this->get_user_permission())) {
            return  redirect('/home');
        }

        // return the id of the categories and stores
        // $category = $product->categories()->pluck('category_product.category_id')->toArray();
        // $stores = $product->stores()->pluck('product_store.store_id')->toArray();


        $response = array();
        if ($product) {
            //load if the categories and stores hav not been loaded as eager loading
            $product->loadMissing(['stores', 'categories']);


            $category = $product->categories;
            $stores = $product->stores;
            $product->categories()->detach($category);
            $product->stores()->detach($stores);
            $path =  public_path() . '/images/products/' . $product['image'];
            if (File::exists($path)) {
                File::delete($path);
            }
            $delete = $product->delete();

            if ($delete) {
                $response['success'] = true;
                $response['messages'] = "Product deleted successfully.";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Plese refersh the page and try again!";
        }

        echo json_encode($response);
    }


    public function viewproduct()
    {
        if (!in_array('viewProduct', $this->get_user_permission())) {
            return  redirect('/home');
        }

        $company_currency = $this->company_currency();
        // get all the category 
        $category_data = Category::with('products')->get();

        $result = array();

        foreach ($category_data as $key => $v) {
            $result[$key]['category'] = $v;
            $result[$key]['products'] = $v->products;
        }

        // based on the category get all the products 
        $html = '<!-- Main content -->
                <!DOCTYPE html>
                <html>
                <head>
                  <meta charset="utf-8">
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
                  <title>Invoice</title>
                  <!-- Tell the browser to be responsive to screen width -->
                  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                  <!-- Bootstrap 3.3.7 -->
                  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
                  <!-- Font Awesome -->
                  <link rel="stylesheet" href=' . asset('assets/bower_components/font-awesome/css/font-awesome.min.css') . '>
                  <link rel="stylesheet" href=' . asset('assets/dist/css/AdminLTE.min.css') . '>
                </head>
                <body>
                <div class="wrapper">
                <section class="invoice">
                <div><a href= "' . route('product.index') . '" class="btn btn-primary mb-1"><< Back </a> </div>
                <div class="row">
                    ';
        foreach ($result as $k => $v) {

            $html .= '<div class="col-md-4 mb-2">
                            <div class="card my-1 h-100">
                            <div class="card-body">
                                <div class="product-info">
                                    <div class="category-title">
                                        <h1>' . $v['category']['name'] . '</h1>
                                    </div>';

            if (count($v['products']) > 0) {
                foreach ($v['products'] as $p_key => $p_value) {
                    $html .= '<div class="product-detail">
                                                        <div class="product-name" style="display:inline-block;">
                                                            <h5>' . $p_value['name'] . '</h5>
                                                        </div>
                                                        <div class="product-price" style="display:inline-block;float:right;">
                                                            <h5>' . $company_currency . ' ' . $p_value['price'] . '</h5>
                                                        </div>
                                                    </div>';
                }
            } else {
                $html .= 'N/A';
            }
            $html .= '</div></div> </div>  </div>';
        }

        $html .= '</div></section></div></body></html>';

        echo $html;
    }
}
