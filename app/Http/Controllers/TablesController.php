<?php

namespace App\Http\Controllers;

use App\Store;
use App\Table;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission =  $this->get_user_permission();
        if (!in_array('viewTable', $permission)) {
            return redirect('/home');
        }

        $store_data =  store::all();

        return view('tables.index')->with('user_permission', $permission)->with('store_data', $store_data);
    }
    public function fetchData()
    {
        $permission =  $this->get_user_permission();
        if (!in_array('viewTable', $permission)) {
            return    redirect('/home');
        }

        $result = array('data' => array());

        $data = table::with('store')->get();

        foreach ($data as $key => $value) {

            $store_data = $value->store;

            // button
            $buttons = '';

            if (in_array('updateTable', $permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if (in_array('deleteTable', $permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $available = ($value['available'] == 1) ? '<span class="label label-success">Available</span>' : '<span class="label label-warning">Unavailable</span>';
            $status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $store_data['name'],
                $value['table_name'],
                $value['capacity'],
                $available,
                $status,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!in_array('createTable', $this->get_user_permission())) {
            return redirect('/home');
        }

        $response = array();
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'table_name' => 'required|unique:tables,table_name,NULL,id,store_id,' . $data['store'],
                'capacity' => 'required|integer',
                'active' => 'required',
                'store' => 'required',
            ]
        );

        if ($validator->fails()) {
            $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
            $response['success'] = false;
            $response['messages'] = $validator->errors()->get('*');
        } else {
            $table = new table();
            $table->table_name = ucwords($data['table_name']);
            $table->capacity = $data['capacity'];
            $table->available = 1;
            $table->active = $data['active'];
            $table->store_id = $data['store'];

            $save = $table->save();
            if ($save) {
                $response['success'] = true;
                $response['messages'] = 'Table succesfully created.';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }
        }

        echo json_encode($response);
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
    public function edit(table $table)
    {
        if (!in_array('updateTable', $this->get_user_permission())) {
            return redirect('/home');
        }
        //
        if ($table) {
            echo json_encode($table);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, table $table)
    {
        if (!in_array('updateStore', $this->get_user_permission())) {
            redirect('/home');
        }

        if ($table) {


            $response = array();
            $data = $request->all();

            $validator = Validator::make(
                $data,
                [
                    'edit_table_name' => 'required|unique:tables,table_name,' . $table['id'] . ',id,store_id,' . $data['edit_store'],
                    'edit_capacity' => 'required|integer',
                    'edit_active' => 'required',
                    'edit_store' => 'required',
                ]
            );

            if ($validator->fails()) {
                $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
                $response['success'] = false;
                $response['messages'] = $validator->errors()->get('*');
            } else {
                // validation is true and we can store data

                $table->table_name = ucwords($data['edit_table_name']);
                $table->capacity = $data['edit_capacity'];
                $table->active = $data['edit_active'];
                $table->store_id = $data['edit_store'];

                $save = $table->save();
                if ($save) {
                    $response['success'] = true;
                    $response['messages'] = 'Table created succesfully.';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error! in the database while creating the brand information.';
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Error! please refresh the page and try again.';
        }

        echo json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(table $table)
    {
        if (!in_array('deleteTable', $this->get_user_permission())) {
            redirect('/home');
        }

        $response = array();
        $table_orders_count = count($table->orders);

        //default error
        $response['success'] = false;
        $response['messages'] = "Refersh the page and try again!";

        if ($table && $table_orders_count == 0) {
            $delete = $table->delete();
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = "Table deleted successfully.";
            } else {
                $response['messages'] = "Error! in the database while removing the brand information.";
            }
        }

        if ($table_orders_count > 0)
            $response['messages'] = "Can't remove a table that has orders!";

        echo json_encode($response);
    }
}
