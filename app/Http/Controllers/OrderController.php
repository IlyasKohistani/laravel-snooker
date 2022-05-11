<?php

namespace App\Http\Controllers;

use App\Company;
use App\Order;
use App\Product;
use App\Store;
use App\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = $this->get_user_permission();
        if (!in_array('viewOrder', $permission)) {
            return redirect('/home');
        }
        return view('orders.index')->with('user_permission', $permission);
    }

    /*
	* Fetches the orders data from the orders table 
	* this function is called from the datatable ajax function
	*/
    public function fetchData()
    {
        $user_permission = $this->get_user_permission();
        if (!in_array('viewOrder', $user_permission)) {
            return redirect('/home');
        }

        $result = array('data' => array());
        $user_store = auth()->user()->store_id;

        $data = order::with(['products', 'table', 'user'])->where('store_id', $user_store)->orderBy('paid_status', 'desc')->orderBy('updated_at', 'desc')->take(200)->get();

        foreach ($data as $key => $value) {

            $table_data = $value->table;
            $count_total_item = 0;

            foreach ($value->products as $product) {
                # code...
                $count_total_item += $product->pivot->qty;
            }

            $user_data = $value->user;
            if ($user_data == null) {
                $user_data['username'] = 'admin';
            }

            // $date = date('d-m-Y', $value['created_at']);
            // $time = date('h:i a', $value['created_at']);

            // $date_time = $date . ' ' . $time;
            $date_time = $value['created_at']->format('d-m-Y H:i:s');

            // button
            $buttons = '';




            if (auth()->user()->id == 1) {
                if (in_array('updatePayment', $user_permission)) {
                    $buttons .= '<a target="__blank" href="' . 'order/index/printDiv/' . $value['id'] . '" class="btn btn-default"><i class="fa fa-print"></i></a>';
                }
                if (in_array('updateOrder', $user_permission)) {
                    $buttons .= ' <a href="order/' . $value['id'] . '/edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                }
                if (in_array('updatePayment', $user_permission)) {
                    $buttons .= ' <a href="' . 'order/' . $value['id'] . '" class="btn btn-default"><i class="fa fa-credit-card"></i></a>';
                }
                if (in_array('deleteOrder', $user_permission)) {
                    $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
                }
            } else {
                if ($value['paid_status'] == 1) {
                    if (in_array('updatePayment', $user_permission)) {
                        $buttons .= '<a target="__blank" href="' . 'order/index/printDiv/' . $value['id'] . '" class="btn btn-default"><i class="fa fa-print"></i></a>';
                    }
                    if (in_array('updateOrder', $user_permission)) {
                        $buttons .= ' <a class="btn btn-default" disabled><i class="fa fa-pencil"></i></a>';
                    }
                    if (in_array('updatePayment', $user_permission)) {
                        $buttons .= ' <a  class="btn btn-default" disabled><i class="fa fa-credit-card"></i></a>';
                    }
                    if (in_array('deleteOrder', $user_permission)) {
                        $buttons .= ' <a class="btn btn-default " disabled><i class="fa fa-trash"></i></a>';
                    }
                } else if ($value['paid_status'] == 2) {
                    if (in_array('updatePayment', $user_permission)) {
                        $buttons .= '<a  class="btn btn-default" disabled><i class="fa fa-print"></i></a>';
                    }
                    if (in_array('updateOrder', $user_permission)) {
                        $buttons .= ' <a href="order/' . $value['id'] . '/edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                    }
                    if (in_array('updatePayment', $user_permission)) {
                        $buttons .= ' <a  class="btn btn-default" disabled><i class="fa fa-credit-card"></i></a>';
                    }
                    if (in_array('deleteOrder', $user_permission)) {
                        $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
                    }
                } else {
                    if (in_array('updatePayment', $user_permission)) {
                        $buttons .= '<a  class="btn btn-default" disabled><i class="fa fa-print"></i></a>';
                    }
                    if (in_array('updateOrder', $user_permission)) {
                        $buttons .= ' <a href="order/' . $value['id'] . '/edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
                    }
                    if (in_array('updatePayment', $user_permission)) {
                        $buttons .= ' <a href="' . 'order/' . $value['id'] . '" class="btn btn-default"><i class="fa fa-credit-card"></i></a>';
                    }
                    if (in_array('deleteOrder', $user_permission)) {
                        $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
                    }
                }
            }


            if ($value['paid_status'] == 1) {
                $paid_status = '<span class="label label-success">Paid</span>';
            } else if ($value['paid_status'] == 2) {
                $paid_status = '<span class="label label-warning">Open</span>';
            } else {
                $paid_status = '<span class="label label-default">Closed</span>';
            }

            $result['data'][$key] = array(
                $value['bill_no'],
                $table_data['table_name'],
                $user_data['username'] . (($value['comment']) ? '<a tabindex="0" role="button" class="hover_show_comment btn btn-link pull-right" data-toggle="popover" data-content="' . $value['comment'] . '" data-trigger="focus" style="padding:0;"><i  class=" fa fa-comment-o"></i></a>' : ''),
                $date_time,
                $count_total_item . '<a tabindex="0" role="button" id="' . $value['id'] . '" class="hover_show_products btn btn-link pull-right" data-toggle="popover" data-trigger="focus" style="padding:0;"><i  class=" fa fa-eye"></i></a>',
                $value['net_amount'],
                $paid_status,
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
        if (!in_array('createOrder', $this->get_user_permission())) {
            return  redirect('/home');
        }




        $company = Company::find(1);
        $data = [
            'table_data' => Table::all()->where('active', 1)->where('available', 1),
            'company_data' => $company,
            'is_vat_enabled' => ($company['vat_charge_value'] > 0) ? true : false,
            'is_service_enabled' => ($company['service_charge_value'] > 0) ? true : false,
            'products' => Product::all()->where('active', 1)
        ];
        return view('orders.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!in_array('createOrder', $this->get_user_permission())) {
            return redirect('/home');
        }
        $company_data = Company::find(1);



        // dd(URL::previous());

        $data = request()->all();


        $this->validate(
            request(),
            [
                'table_name' => 'required',
                'product' => 'required|array|min:1',
                'product.*' => 'required',
                'qty.*'   => 'required|min:1',
                'is_game.*' => 'required|boolean'
            ]
        );

        //check if table is available
        $table = table::find($data['table_name']);
        if ($table['available'] != 1) {
            return redirect()->back()->withErrors('Table is not available.');
        }



        $service_charge = $company_data['service_charge_value'];
        $vat_charge = $company_data['vat_charge_value'];
        $vat_charge_value =   round((($data['gross_amount_value'] / 100) * $vat_charge), 2);
        $service_charge_value =   round((($data['gross_amount_value'] / 100) * $service_charge), 2);
        $net_amount_value =   round((($data['gross_amount_value'] + $service_charge_value) + $vat_charge_value), 2);

        $user_id = auth()->user()->id;
        // get store id from user id 
        $user_data = auth()->user();
        $store_id = $user_data['store_id'];

        $bill_no = 'BILPR-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
        $order = new order();
        $order->bill_no = $bill_no;
        $order->gross_amount = $data['gross_amount_value'];
        $order->service_charge_rate = $service_charge;
        $order->service_charge_amount = ($service_charge_value > 0) ? $service_charge_value : 0;
        $order->vat_charge_rate = $vat_charge;
        $order->vat_charge_amount = ($vat_charge_value > 0) ? $vat_charge_value : 0;
        $order->net_amount = $net_amount_value;
        $order->discount =  0;
        $order->paid_status = 2;
        $order->user_id = $user_id;
        $order->table_id = $data['table_name'];
        $order->store_id = $store_id;
        $order->comment = "";

        $order->save();
        $order->fresh();
        $order->refresh();
        $order_id = $order->id;
        $items = [];
        $count_product = count($data['product']);
        for ($x = 0; $x < $count_product; $x++) {
            array_push($items, [
                'order_id' => $order_id,
                'product_id' => $data['product'][$x],
                'qty' => $data['qty'][$x],
                'rate' => $data['rate_value'][$x],
                'amount' => $data['amount_value'][$x],
                'is_game' => $data['is_game'][$x] == 1 ? 1 : 0,
            ]);
        }



        $order->products()->attach(array_values($items));


        // update the table status
        $table->available = 2;
        $table->save();

        if ($order_id) {
            session()->flash('success', 'Order created Successfully');
            return redirect('/order');
        } else {
            session()->flash('errors', 'Error occurred!!');
            return redirect('/order');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        if (!in_array('updatePayment', $this->get_user_permission())) {
            return redirect('/home');
        }
        $data = [];

        if (empty($order)) {
            return redirect('/home');
        }




        $status = $order['paid_status'];
        if ($status == 1 && auth()->user()->id != 1) {
            return redirect('/home');
        }

        // false case
        $data['table_data'] = Table::all()->where('active', 1)->where('available', 1);

        $data['company_data'] = Company::find(1);
        $data['is_vat_enabled'] = ($data['company_data']['vat_charge_value'] > 0) ? true : false;
        $data['is_service_enabled'] = ($data['company_data']['service_charge_value'] > 0) ? true : false;

        $result = array();

        if (empty($order)) {
            return redirect()->back()->withErrors('The request data does not exists');
        }

        $result['order'] = $order;
        $orders_item = $order->Products;

        foreach ($orders_item as $k => $v) {
            $result['order_item'][] = $v;
        }

        $table_data = $order->table;

        $result['order_table'] = $table_data;

        $data['order_data'] = $result;

        $data['products'] = Product::all()->where('active', 1);
        $data['user_permission'] = $this->get_user_permission();


        return view('orders.payment')->with($data);
    }

    /*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
    public function getTableProductRow($store_id = 1)
    {

        if (Auth::check()) {
            $store_id = Auth::user()->store->id;
        }

        $products = Store::find($store_id)->products()->where('active', 1)->get();
        echo json_encode($products);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        if (!in_array('updateOrder', $this->get_user_permission())) {
            return redirect('/home');
        }

        $data = [];

        if (empty($order)) {
            return redirect('/home');
        }


        $status = $order['paid_status'];
        if ($status == 1 && auth()->user()->id != 1) {
            return redirect('/home');
        }

        // false case
        $data['table_data'] = Table::all()->where('active', 1)->where('available', 1);

        $data['company_data'] = Company::find(1);
        $data['is_vat_enabled'] = ($data['company_data']['vat_charge_value'] > 0) ? true : false;
        $data['is_service_enabled'] = ($data['company_data']['service_charge_value'] > 0) ? true : false;

        $result = array();

        if (empty($order)) {
            session()->flash('errors', 'The request data does not exists');
            return redirect()->back();
        }

        $result['order'] = $order;
        $orders_item = $order->Products;

        foreach ($orders_item as $k => $v) {
            $result['order_item'][] = $v;
        }

        $table_data = $order->table;

        $result['order_table'] = $table_data;


        $data['order_data'] = $result;

        $data['products'] = Product::all()->where('active', 1);
        $data['user_permission'] = $this->get_user_permission();


        return view('orders.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if (!in_array('updateOrder', $this->get_user_permission())) {
            return redirect('/home');
        }
        $company_data = Company::find(1);
        $data = request()->all();

        if (empty($order)) {
            return redirect('/home');
        }

        $this->validate(
            request(),
            [
                'product' => 'required|array|min:1',
                'product.*' => 'required',
                'table_name' => 'required',
                'qty.*'   => 'required|min:1',
                'is_game.*' => 'required|boolean',
                'paid_status' => 'required|in:2,3',
                'comment' => 'nullable',
            ],
        );


        //get old table id
        $old_table_id = $order['table_id'];

        //new table data
        $table = table::find($data['table_name']);
        if ($table['id'] != $old_table_id && $table['available'] != 1) {
            return redirect()->back()->withErrors('Table is not available.');
        }

        $status = $order['paid_status'];
        if ($status == 1 && auth()->user()->id != 1) {
            return redirect('/home');
        }


        //count vat charge and amounts not from front
        $service_charge = $company_data['service_charge_value'];
        $vat_charge = $company_data['vat_charge_value'];
        $vat_charge_value =   round((($data['gross_amount_value'] / 100) * $vat_charge), 2);
        $service_charge_value =   round((($data['gross_amount_value'] / 100) * $service_charge), 2);
        $net_amount_value =   round((($data['gross_amount_value'] + $service_charge_value) + $vat_charge_value), 2);



        //add data to order instance
        $pre_paid_status = $order->paid_status;
        $order->gross_amount = $data['gross_amount_value'];
        $order->service_charge_rate = $service_charge;
        $order->service_charge_amount = ($service_charge_value > 0) ? $service_charge_value : 0;
        $order->vat_charge_rate = $vat_charge;
        $order->vat_charge_amount = ($vat_charge_value > 0) ? $vat_charge_value : 0;
        $order->net_amount = $net_amount_value;
        $order->discount = 0;
        $order->paid_status = $data['paid_status'];
        $order->table_id =  $data['table_name'];
        $order->comment = $data['comment'];
        $order->end_time =  $data['paid_status'] == 3 ? $data['end_time'] : null;
        $order->total_minutes = $data['paid_status'] == 3 ? $data['total_minutes'] : null;


        if ($pre_paid_status != $order->paid_status) {
            $table = $order->table;
            if ($order->paid_status == 3) {
                $table->available = 1;
            } else {
                if ($table->available == 2)
                    return redirect()->back()->withErrors('You can\'t open this order. The table is already in use.');
                $table->available = 2;
            }
        }


        //detach old data of pivot of the order
        $order->products()->detach();
        $order->save();
        //save table status
        if ($pre_paid_status != $order->paid_status)
            $table->save();
        //update order object
        $order->fresh();


        $order_id = $order->id;

        $items = [];
        $count_product = count($data['product']);
        for ($x = 0; $x < $count_product; $x++) {
            array_push($items, [
                'order_id' => $order_id,
                'product_id' => $data['product'][$x],
                'qty' => $data['qty'][$x],
                'rate' => $data['rate_value'][$x],
                'amount' => $data['amount_value'][$x],
                'is_game' => $data['is_game'][$x] == 1 ? 1 : 0
            ]);
        };

        //if do not use array_values method it will update the data but attach
        // the data again to pivot without deleting old data
        $order->products()->sync(array_values($items));

        // update the table status
        if ($table['id'] != $old_table_id) {
            $old_table = table::find($old_table_id);
            $old_table->available = 1;
            $table->available = 2;
            $old_table->save();
            $table->save();
        }

        if ($order_id) {
            session()->flash('success', 'Order updated Successfully');
            return ($order->paid_status == 3) ? redirect()->route('order.show', $order->id) : redirect('/order');
        } else {
            return redirect('/order')->withErrors('Error occurred!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        if (!in_array('deleteOrder', $this->get_user_permission())) {
            return redirect('/home');
        }
        $status = $order['paid_status'];
        if ($status == 1 && auth()->user()->id != 1) {
            return redirect('/home');
        }
        $response = array();
        if (!empty($order)) {
            if ($status == 2) {
                $table = table::find($order['table_id']);
                $table->available = 1;
                $table->save();
            }
            $products = $order->products;
            $order->products()->detach($products);
            $delete =  $order->delete();
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = "Order deleted successfully.";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the order information";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Plese refersh the page and try again!";
        }

        echo json_encode($response);
    }


    /*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
    public function getProductValueById($id)
    {
        $product = Product::find($id);
        if ($product) {
            echo json_encode($product);
        }
    }




    /*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
    public function printDiv(Order $order)
    {
        $company_currency = $this->company_currency();


        if (!in_array('viewOrder', $this->get_user_permission())) {
            redirect('dashboard', 'refresh');
        }

        if ($order) {
            $order_data = $order;

            $status = $order_data['paid_status'];
            if ($status != 1 && auth()->user()->id != 1) {
                return redirect('/home');
            }


            $orders_items = $order_data->products;
            $company_info = Company::find(1);
            $store_data = $order_data->store;

            $order_date = $order_data['created_at']->format('d/m/Y');
            $paid_status = ($order_data['paid_status'] == 1) ? "Paid" : (($order_data['paid_status'] == 2) ? 'Open' : 'Closed');

            $order_time_played =
                ($order_data['end_time']) ? '<b>Time: </b> ' . $order_data['created_at']->format('H:i') . ' - ' . $order_data['end_time']->format('H:i') . ', ' . $order_data['total_minutes'] . 'm<br>' : '';

            $table_data = $order_data->table;

            if ($order_data['discount'] > 0) {
                $discount = $company_currency . ' ' . $order_data['discount'];
            } else {
                $discount = '0';
            }


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
			  <link rel="stylesheet" href="' . asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') . '">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="' . asset('assets/bower_components/font-awesome/css/font-awesome.min.css') . '">
              <link rel="stylesheet" href="' . asset('assets/dist/css/AdminLTE.min.css') . '">
        <style media="print">
        @page {
        size: auto;
        margin: 0;
       }
       @media print {
                    body{
                         padding: 4vw;
                        }
                    }
        </style>
            </head>
            
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          ' . $company_info['company_name'] . '
			          <small class="pull-right">Date: ' . $order_date . '</small>
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col">
			        <b>Bill ID: </b> ' . $order_data['bill_no'] . '<br>
			        <b>Store Name: </b> ' . $store_data['name'] . '<br>
			        <b>Table name: </b> ' . $table_data['table_name'] . '<br>
			        <b>Total items: </b> ' . count($orders_items) . '<br>
			        ' . $order_time_played . '<br>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            <th>Price</th>
			            <th>Qty</th>
			            <th>Amount</th>
			          </tr>
			          </thead>
			          <tbody>';

            foreach ($orders_items as $k => $v) {



                $html .= '<tr>
				            <td>' . $v['name'] . '</td>
				            <td>' . $company_currency . ' ' . $v->pivot->rate . '</td>
				            <td>' . $v->pivot->qty . '</td>
				            <td>' . $company_currency . ' ' . $v->pivot->amount . '</td>
			          	</tr>';
            }

            $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			            <tr>
			              <th style="width:50%">Gross Amount:</th>
			              <td>' . $company_currency . ' ' . $order_data['gross_amount'] . '</td>
			            </tr>';

            if ($order_data['service_charge_amount'] > 0) {
                $html .= '<tr>
				              <th>Service Charge (' . $order_data['service_charge_rate'] . '%)</th>
				              <td>' . $company_currency . ' ' . $order_data['service_charge_amount'] . '</td>
				            </tr>';
            }

            if ($order_data['vat_charge_amount'] > 0) {
                $html .= '<tr>
				              <th>Vat Charge (' . $order_data['vat_charge_rate'] . '%)</th>
				              <td>' . $company_currency . ' ' . $order_data['vat_charge_amount'] . '</td>
				            </tr>';
            }


            $html .= ' <tr>
			              <th>Discount:</th>
			              <td>' . $discount . '</td>
			            </tr>
			            <tr>
			              <th>Net Amount:</th>
			              <td>' . $company_currency . ' ' . $order_data['net_amount'] . '</td>
			            </tr>
			            <tr>
			              <th>Status:</th>
			              <td>' . $paid_status . '</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	    </html>';

            echo $html;
        }
    }
    /*
	* It  fetchs the order data. 
	* and will pay the order
    */

    public function pay(request $request, Order $order)
    {
        if (!in_array('updatePayment', $this->get_user_permission())) {
            return redirect('/home');
        }
        $data = request()->all();


        if (empty($order)) {
            return redirect('/home');
        }




        $status = $order['paid_status'];
        if ($status == 1 && auth()->user()->id != 1) {
            return redirect('/home');
        }

        $order->paid_status = 1;


        $table = $order->table;
        $table->available = 1;
        $table->save();

        $save =  $order->save();

        if ($save) {
            session()->flash('success', 'Order updated Successfully');
            return redirect('/order');
        } else {
            return redirect('/order')->withErrors('Error occurred!');
        }
    }

    // fetchs products that ordered by user to show as tooltip
    public function fetchProduct(Order $order)
    {
        $products = $order->products;

        $html = '<style type="text/css">.popover {max-width: 310px;}.popover-table tr th,.popover-table tr td{padding:5px 3px;font-size:13px;}</style><table class="table table-bordered table-striped po text-center popover-table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col"> Product </th>
            <th scope="col"> Quantity </th>
            <th scope="col"> Amount </th>
          </tr>
        </thead>
        <tbody>';

        $x = 1;
        foreach ($products as $product) {
            $total =    round($product->pivot->amount + (($order['service_charge_rate'] / 100) * $product->pivot->amount) +  (($order['vat_charge_rate'] / 100) * $product->pivot->amount), 2);

            # code...
            $html .= ' <tr>
            <th scope="row" class="text-center">' . $x . '</th>
            <td>' . $product['name'] . '</td>
            <td>' . $product->pivot->qty . '</td>
            <td>' . $total . '</td>
          </tr>';
            $x++;
        }

        $html .= '</tbody></table>';


        echo $html;
    }
}
