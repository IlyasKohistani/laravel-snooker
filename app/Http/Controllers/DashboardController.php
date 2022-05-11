<?php

namespace App\Http\Controllers;

use App\Company;
use App\Order;
use App\Product;
use App\Store;
use App\Table;
use App\User;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

  public function index()
  {

    $permission = $this->get_user_permission();

    //get user type based on their pemission and user id
    $user_data = auth()->user();
    $user_id = $user_data->id;
    $is_admin = ($user_id == 1) ? true : false;
    $is_waiter = (in_array('createOrder', $permission)) ? true : false;
    $is_cashier = (in_array('updatePayment', $permission)) ? true : false;


    //get company data and count other data for admin and add into data array
    $company = Company::find(1);
    $data['table_data'] = Table::all()->where('active', 1)->where('available', 1);
    $data['company_data'] = $company;
    $data['is_vat_enabled'] = ($company['vat_charge_value'] > 0) ? true : false;
    $data['is_service_enabled'] = ($company['service_charge_value'] > 0) ? true : false;
    $data['products'] = Product::all()->where('active', 1);
    $data['is_admin'] = $is_admin;
    $data['is_waiter'] = $is_waiter;
    $data['is_cashier'] = $is_cashier;
    $data['total_products'] = Product::all()->count();
    $data['total_paid_orders'] = order::where('paid_status', 1)->get()->count();
    $data['total_users'] = User::all()->count();
    $data['total_stores'] = Store::all()->count();
    $data['user_permission'] = $permission;


    return view('dashboard')->with($data);
  }

  public function fetchWaiterTables()
  {

    //get user and tables data from database
    $user_data = auth()->user();
    $table_data = Table::with('store')->where('active', 1)->where('store_id', $user_data->store_id)->orderby('table_name')->get();
    $tables = '';


    $table_data->load([
      'orders' => function ($q) {
        $q->where('paid_status', 2);
      }
    ]);
    foreach ($table_data as $data) {

      //get the order data based on table id
      $tableid =  $data["id"];

      //set function data
      $tablename = (string) $data["table_name"];
      $function = $tableid . ",'" . $tablename . "'";


      //set button to waiter based on table data 
      if ($data['available'] == 1) {
        $button_click_function = ' data-toggle="modal" onclick="tableId(' . $function . ')" data-target="#addModal" ';
        $button = '<button  class="small-box-footer btn btn-link" ' . $button_click_function . ' 
        style="width: 100%">Add Order <i class="fa fa-arrow-circle-right"></i></button>';
      } else {

        $order = $data->orders->where('paid_status', 2)->first();

        $button = '<a href="' . route('order.edit', $order['id']) . '"  class="small-box-footer btn btn-link" style="width: 100%" >
        Edit Order <i class="fa fa-arrow-circle-right"></i></a>';
      }



      //set the css class of the table box and the the capacity of table based on data of table
      $class =  ($data['available'] == 1) ? 'bg-green' : 'bg-red';
      $capacity = ($data['capacity'] == 1) ? $data['capacity'] . ' Person' : $data['capacity'] . ' People';


      //set the table data and make html variable and pass it to dashboard
      $tables .= '<div class="col-lg-3 col-xs-6">
        <!-- small box -->
  
        <div class="small-box ' . $class . '">
          <div class="inner">
            <h3 class="name">' . $data['table_name'] . '</h3>
            <h4 class="capacity">
              ' . $capacity . ' </h4>
          </div>
          <div class="icon" style="top:15px;">
            <i class="fa fa-table"></i>
          </div>
          ' . $button . '
        </div>
      </div>';
    }

    echo $tables;
  }


  public function fetchCashierTables()
  {

    //get user and tables data from database
    $user_data = auth()->user();
    $table_data = Table::where('active', 1)->where('store_id', $user_data->store_id)->orderby('table_name')->get();
    $tables = '';



    $table_data->load([
      'orders' => function ($q) {
        $q->where('paid_status', 2);
      }
    ]);
    foreach ($table_data as $data) {
      //get the order data based on table id

      //set button to cashier to pay the order if it has order
      if ($data['available'] == 2) {

        $order = $data->orders->where('paid_status', 2)->first();

        $button = '<a href="' . route('order.show', $order['id']) . '"  class="small-box-footer btn btn-link" style="width: 100%" >
        Pay Order <i class="fa fa-arrow-circle-right"></i></a>';
      } else {
        $button = '<a href="#"  class="small-box-footer btn btn-link" style="width: 100%" >
        Available <i class="fa fa-arrow-circle-right"></i></a>';
      }


      //set the css class of the table box and the the capacity of table based on data of table
      $class =  ($data['available'] == 1) ? 'bg-green' : 'bg-red';
      $capacity = ($data['capacity'] == 1) ? $data['capacity'] . ' Person' : $data['capacity'] . ' People';


      //set the table data and make html variable and pass it to dashboard
      $tables .= '<div class="col-lg-3 col-xs-6">
        <!-- small box -->
  
        <div class="small-box ' . $class . '">
          <div class="inner">
            <h3 class="name">' . $data['table_name'] . '</h3>
            <h4 class="capacity">
              ' . $capacity . ' </h4>
          </div>
          <div class="icon" style="top:15px;">
            <i class="fa fa-table"></i>
          </div>
          ' . $button . '
        </div>
      </div>';
    }

    echo $tables;
  }
}
