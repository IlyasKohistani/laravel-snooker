<?php

namespace App\Http\Controllers;

use App\Order;
use App\Store;

class ReportController extends Controller
{



    /* 
                                    * redirect route methods
                                     
    */


    /* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
    public function index()
    {
        $this->isPermit();
        return view('reports.index')->with($this->indexReportData());
    }

    /* 
    * It redirects to the report page
    * and based on the year and month, all the orders data are fetch from the database.
    */
    public function dailyReport()
    {
        $this->isPermit();
        return view('reports.daily')->with($this->dailyReportData());
    }

    /* 
    * It redirects to the product  report page
    * and based on the year ,store and product , all the orders data are fetch from the database.
    */
    public function productReport()
    {
        $this->isPermit();
        return view('reports.product')->with($this->productReportData());
    }

    /* 
    * It redirects to the store  report page
    * and based on the year and store  all the orders data are fetch from the database.
    */
    public function storeReport()
    {
        $this->isPermit();
        return view('reports.store')->with($this->storeReportData());
    }

    /* 
    * It redirects to the staff  report page
    * and based on the store and staff  all the orders data are fetch from the database.
    */
    public function staffReport()
    {
        $this->isPermit();
        return view('reports.staff')->with($this->staffReportData());
    }







    /* 
                                    * fetching data for reports methods
                                     
    */




    /* getting all the orders data based on year */
    public function indexReportData()
    {


        $today_year = date('Y');
        if (!empty(request()->all())) {
            $request = request()->all();
            $today_year = $request['select_year'];
        }

        $data = [];

        $result_by_year = Order::where('paid_status', 1)->whereYear('created_at', $today_year)->with('products')->get();

        //in order to prevent three queries fetch data once and send it as variable to fuctions
        $result = Order::where('paid_status', 1)->get();

        $order_data = $this->getOrderData($today_year, $result_by_year);
        $data['report_years'] = $this->getOrderYear($result);

        $final_order_data = array();
        foreach ($order_data as $k => $v) {

            if (count($v) > 1) {
                $total_amount_earned = array();
                $total_product = array();
                foreach ($v as $k2 => $v2) {
                    if ($v2) {
                        $total_amount_earned[] = $v2['net_amount'];
                        $product_qty = 0;
                        foreach ($v2->products as $product) {
                            # code...
                            $product_qty += $product->pivot->qty;
                        }
                        $total_product[] =  $product_qty;
                    }
                }
                $final_order_data[$k] = array_sum($total_amount_earned);
                $total_products[$k] = array_sum($total_product);
            } else {
                $final_order_data[$k] = 0;
                $total_products[$k] = 0;
            }
        }

        $data['selected_year'] = $today_year;
        $data['company_currency'] = $this->company_currency();
        $data['results'] = $final_order_data;
        $data['quantity'] = $total_products;

        return (!isset($request)) ?  $data : view('reports.index')->with($data);
    }


    /* getting all the orders data based on year */
    public function dailyReportData()
    {

        $today_year = date('Y');
        $today_month = date('m');
        $today_day = date('D');

        if (!empty(request()->all())) {
            $request = request()->all();
            if (!empty($request['select_year'])) $today_year = $request['select_year'];
            if (!empty($request['select_month'])) $today_month = $request['select_month'];
        }


        //in order to prevent three queries fetch data once and send it as variable to fuctions
        $result = Order::where('paid_status', 1)->with('products')->get();


        $order_data = $this->getOrderDataByDay($today_year, $today_month, $result);
        $data['report_years'] = $this->getOrderYear($result);
        $data['report_month'] = $this->getOrderMonth($today_year, $result);

        $final_order_data = array();
        $product_items_count = array();
        foreach ($order_data as $k => $v) {

            if (count($v) > 1) {
                $total_amount_earned = array();
                $total_product = array();
                foreach ($v as $k2 => $v2) {
                    if ($v2) {
                        $total_amount_earned[] = $v2['net_amount'];
                        $product_qty = 0;
                        foreach ($v2->products as $product) {
                            # code...
                            $product_qty += $product->pivot->qty;
                            $p_vat_charged = $v2['vat_charge_rate'] *  $product->pivot->amount / 100;
                            $p_service_charged = $v2['service_charge_rate'] *  $product->pivot->amount / 100;
                            if (isset($product_items_count[$k][$product->name])) {
                                $product_items_count[$k][$product->name]['quantity'] += $product->pivot->qty;
                                $product_items_count[$k][$product->name]['amount'] += round(($product->pivot->amount + $p_service_charged + $p_vat_charged), 2);
                            } else {
                                $product_items_count[$k][$product->name]['quantity'] = $product->pivot->qty;
                                $product_items_count[$k][$product->name]['amount'] = round(($product->pivot->amount + $p_service_charged + $p_vat_charged), 2);
                            }
                        }
                        $total_product[] =  $product_qty;
                    }
                }
                $final_order_data[$k] = array_sum($total_amount_earned);
                $total_products[$k] = array_sum($total_product);
            } else {
                $final_order_data[$k] = 0;
                $total_products[$k] = 0;
            }
        }

        $data['selected_year'] = $today_year;
        $data['selected_month'] = $today_month;
        $data['company_currency'] = $this->company_currency();
        $data['results'] = $final_order_data;
        $data['quantity'] = $total_products;
        $data['product_items_count'] = json_encode($product_items_count, JSON_UNESCAPED_SLASHES);

        return (!isset($request)) ?  $data : view('reports.daily')->with($data);
    }

    /* getting all the orders data based on product and store in each year */
    public function productReportData()
    {

        $store_data = Store::orderBy('id', 'asc')->with('products')->get();


        $today_year = date('Y');
        $store_id = $store_data[0]['id'];
        $product_data = $store_data[0]->products->sortBy('name');
        $product_id = $product_data->pluck('id')->first();


        if (!empty(request()->all())) {
            $request = request()->all();
            if (!empty($request['select_year'])) $today_year = $request['select_year'];
            if (!empty($request['select_store'])) $store_id = $request['select_store'];
            if (!empty($request['select_store'])) $product_data = $store_data->where('id', $store_id)->first()->products->sortBy('name');
            if (!empty($request['select_product'])) $product_id = $request['select_product'];
        }


        //in order to prevent three queries fetch data once and send it as variable to fuctions
        $result = Order::where('paid_status', 1)->where('store_id', $store_id)->get();

        //get store product orders years
        $data['report_years'] = $this->getOrderYear($result);
        //on store change check if  selected year is not exist in list of order years then update it
        if (!empty(request()->all())) {
            if (!empty($data['report_years']) && !in_array($request['select_year'], $data['report_years']))  $today_year = $data['report_years'][0];
            if (!empty($product_data->pluck('id')->toArray()) && !in_array($request['select_product'], $product_data->pluck('id')->toArray()))  $product_id = $product_data[0]['id'];
        }

        $order_data = $this->getProductOrderReport($today_year, $store_id, $product_id);


        $final_parking_data = array();
        $total_products = array();
        foreach ($order_data as $k => $v) {

            if (count($v) > 1) {
                $total_amount_earned = array();
                $total_product = array();
                foreach ($v as $v2) {
                    if ($v2) {
                        $total_amount_earned[] = $v2['amount'] + (($v2['amount'] / 100) * $v2['vat_charge_rate']) + (($v2['amount'] / 100) * $v2['service_charge_rate']);
                        $total_product[] = $v2['qty'];
                    }
                }
                $final_parking_data[$k] = array_sum($total_amount_earned);
                $total_products[$k] = array_sum($total_product);
            } else {
                $final_parking_data[$k] = 0;
                $total_products[$k] = 0;
            }
        }

        $data['selected_store'] = $store_id;
        $data['store_data'] = $store_data;
        $data['product_data'] = $product_data;
        $data['selected_product'] = $product_id;
        $data['selected_year'] = $today_year;
        $data['company_currency'] = $this->company_currency();
        $data['results'] = $final_parking_data;
        $data['products'] = $total_products;


        return (!isset($request)) ?  $data : view('reports.product')->with($data);
    }


    /* getting all the orders data based on store in each year */
    public function storeReportData()
    {

        $today_year = date('Y');
        $store_data = Store::orderBy('id', 'asc')->get();
        $store_id = $store_data[0]['id'];


        if (!empty(request()->all())) {
            $request = request()->all();
            if (!empty($request['select_year'])) $today_year = $request['select_year'];
            if (!empty($request['select_store'])) $store_id = $request['select_store'];
        }




        $result = Order::where('store_id', $store_id)->where('paid_status', 1)->with('products')->get();
        $data['report_years'] = $this->getOrderYear($result);

        //on store change check if  selected year is not exist in list of order years then update it
        if (!empty(request()->all())) {
            if (!empty($data['report_years']) && !in_array($request['select_year'], $data['report_years']))  $today_year = $data['report_years'][0];
        }

        $order_data = $this->getStoreOrderData($today_year, $store_id, $result);



        $final_parking_data = array();
        foreach ($order_data as $k => $v) {

            if (count($v) > 1) {
                $total_amount_earned = array();
                foreach ($v as $v2) {
                    if ($v2) {
                        $total_amount_earned[] = $v2['net_amount'];
                    }
                }
                $final_parking_data[$k] = array_sum($total_amount_earned);
            } else {
                $final_parking_data[$k] = 0;
            }
        }


        $data['selected_store'] = $store_id;
        $data['store_data'] = $store_data;
        $data['selected_year'] = $today_year;
        $data['company_currency'] = $this->company_currency();
        $data['results'] = $final_parking_data;


        return (!isset($request)) ?  $data : view('reports.store')->with($data);
    }

    /* getting all the orders data based on staff and store in each year */
    public function staffReportData()
    {


        $store_data = Store::orderBy('id', 'asc')->with('users')->get();

        $today_year = date('Y');
        $store_id = $store_data[0]['id'];
        $user_data = $store_data[0]->users->sortBy('name');
        $user_id = $user_data[0]['id'];


        // $store_id = $store_data[0]['id'];
        // $product_data = $store_data[0]->products->sortBy('name');
        // $product_id = $product_data->pluck('id')->first();

        if (!empty(request()->all())) {
            $request = request()->all();
            if (!empty($request['select_year'])) $today_year = $request['select_year'];
            if (!empty($request['select_store'])) $store_id = $request['select_store'];
            $user_data = $store_data->where('id', $store_id)->first()->users->sortBy('name');
            if (!empty($request['select_user'])) $user_id = $request['select_user'];
        }


        //in order to prevent three queries fetch data once and send it as variable to fuctions
        $result = Order::where('paid_status', 1)->where('store_id', $store_id)->get();

        //get store product orders years
        $data['report_years'] = $this->getOrderYear($result);

        //on store change check if  selected year is not exist in list of order years then update it
        if (!empty(request()->all())) {
            if (!empty($data['report_years']) && !in_array($request['select_year'], $data['report_years']))  $today_year = $data['report_years'][0];
            if (!empty($user_data->pluck('id')->toArray()) && !in_array($request['select_user'], $user_data->pluck('id')->toArray()))  $user_id = $user_data[0]['id'];
        }

        $order_data = $this->getUserOrderData($today_year, $result, $user_id);

        $final_parking_data = array();
        foreach ($order_data as $k => $v) {

            if (count($v) > 1) {
                $total_amount_earned = array();
                foreach ($v as $v2) {
                    if ($v2) {
                        $total_amount_earned[] = $v2['net_amount'];
                    }
                }
                $final_parking_data[$k] = array_sum($total_amount_earned);
            } else {
                $final_parking_data[$k] = 0;
            }
        }


        $data['selected_store'] = $store_id;
        $data['store_data'] = $store_data;
        $data['selected_user'] = $user_id;
        $data['user_data'] = $user_data;
        $data['selected_year'] = $today_year;
        $data['company_currency'] = $this->company_currency();
        $data['results'] = $final_parking_data;


        return (!isset($request)) ?  $data : view('reports.staff')->with($data);
    }


    /* 
                                    * all helper methods
                                     
    */




    /* getting all the orders data based on year and month */
    public function getOrderDataByDay($year, $month, $result)
    {
        if ($year) {
            $day = $this->days();


            $final_data = array();
            foreach ($day as $day_k => $day_v) {
                $get_mon_year = $year . '-' . $month . '-' . $day_v;
                if ($day_k != 0) {
                    $yesterday = $year . '-' . $month . '-' . $day[$day_k - 1];
                    $final_data[$yesterday][] = '';
                }
                $final_data[$get_mon_year][] = '';
                foreach ($result as $k => $v) {
                    $month_year = $v['created_at']->format('Y-m-d');
                    if ($get_mon_year == $month_year) {
                        if ($v['created_at'] >= date($get_mon_year . ' 04:00:00')) {
                            $final_data[$get_mon_year][] = $v;
                        } else {
                            if ($day_k != 0) {
                                $final_data[$yesterday][] = $v;
                            }
                        }
                    }
                }
            }

            return $final_data;
        }
    }

    //get product report based on year and store
    public function getProductOrderReport($year, $store, $product_id)
    {
        if ($year && $store) {
            $months = $this->months();



            $result = Order::where('store_id', $store)->where('paid_status', 1)
                ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
                ->select('orders.*', 'order_product.product_id', 'order_product.qty', 'order_product.amount', 'order_product.rate')
                ->where('product_id', $product_id)->get();


            $final_data = array();
            foreach ($months as  $month_y) {
                $get_mon_year = $year . '-' . $month_y;

                $final_data[$get_mon_year][] = '';
                foreach ($result as $v) {
                    $month_year = $v['created_at']->format('Y-m');

                    if ($get_mon_year == $month_year) {
                        $final_data[$get_mon_year][] = $v;
                    }
                }
            }
            return $final_data;
        }
    }

    // getting the order reports based on the year and store
    public function getStoreOrderData($year, $store, $result)
    {
        if ($year && $store) {
            $months = $this->months();

            $final_data = array();
            foreach ($months as  $month_y) {
                $get_mon_year = $year . '-' . $month_y;

                $final_data[$get_mon_year][] = '';
                foreach ($result as $v) {
                    $month_year =  $v['created_at']->format('Y-m');

                    if ($get_mon_year == $month_year) {
                        $final_data[$get_mon_year][] = $v;
                    }
                }
            }

            return $final_data;
        }
    }


    // getting the order reports based on the user and store
    public function getUserOrderData($year, $orders, $user_id)
    {
        if ($year) {
            $months = $this->months();

            $result = $orders->where('user_id', $user_id);

            $final_data = array();
            foreach ($months as $month_y) {
                $get_mon_year = $year . '-' . $month_y;

                $final_data[$get_mon_year][] = '';
                foreach ($result as $v) {
                    $month_year = $v['created_at']->format('Y-m');

                    if ($get_mon_year == $month_year) {
                        $final_data[$get_mon_year][] = $v;
                    }
                }
            }

            return $final_data;
        }
    }

    /* getting the year of the orders */
    private function getOrderYear($result)
    {

        $return_data = array();
        foreach ($result as $k => $v) {
            $date = $v['created_at']->format('Y');
            $return_data[] = $date;
        }

        $return_data = array_unique($return_data);

        return $return_data;
    }

    /* getting the month of the orders */
    public function getOrderMonth($year = null, $result)
    {

        $return_data = array();
        foreach ($result as $k => $v) {
            $date = $v['created_at']->format('m');
            $return_data[] = $date;
        }

        $return_data = array_unique($return_data);

        return $return_data;
    }

    // getting the order reports based on the year and months
    private function getOrderData($year, $result)
    {
        if ($year) {
            $months = $this->months();




            $final_data = array();
            foreach ($months as $month_k => $month_y) {
                $get_mon_year = $year . '-' . $month_y;

                $final_data[$get_mon_year][] = '';
                foreach ($result as $k => $v) {
                    $month_year =  $v['created_at']->format('Y-m');

                    if ($get_mon_year == $month_year) {
                        $final_data[$get_mon_year][] = $v;
                    }
                }
            }

            return $final_data;
        }
    }


    /*getting the arrya of total months*/
    private function months()
    {
        return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
    }
    /*getting the array of total days*/
    private function days()
    {
        return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31');
    }

    //check if user has permission to view this page
    private function isPermit()
    {
        if (!in_array('viewReport', $this->get_user_permission())) {
            return redirect('/home');
        }
    }
}
