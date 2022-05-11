<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

use Illuminate\Http\Request;


class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = $this->get_user_permission();
        if (!in_array('viewStore', $permission)) {
            return redirect('/home');
        }


        return view('stores.index')->with('user_permission', $permission);
    }



    public function fetchData()
    {
        $permission = $this->get_user_permission();

        if (!in_array('viewStore', $permission)) {
            return redirect('/home');
        }

        $result = array('data' => array());

        $data = Store::all()->except(1);

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (in_array('updateStore', $permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if (in_array('deleteStore', $permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['name'],
                $value['address'],
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


        if (!in_array('createStore', $this->get_user_permission())) {
            return redirect('/home');
        }

        $response = array();
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'store_name' => 'unique:stores,name|required',
                'store_address' => 'required',
                'active' => 'required',
            ]
        );

        if ($validator->fails()) {
            $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
            $response['success'] = false;
            $response['messages'] = $validator->errors()->get('*');
        } else {
            // validation is true and we can store data
            $store = new Store();
            $store->name = ucwords($data['store_name']);
            $store->address = ucwords($data['store_address']);
            $store->active = $data['active'];

            $save  =  $store->save();
            if ($save) {
                $response['success'] = true;
                $response['messages'] = 'Store created succesfully.';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error! in the database while creating the brand information.';
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
    public function show(store $store)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(store $store)
    {
        if (!in_array('updateStore', $this->get_user_permission())) {
            return redirect('/home');
        }
        //
        if ($store) {
            echo json_encode($store);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, store $store)
    {
        //
        if (!in_array('updateStore', $this->get_user_permission())) {
            redirect('/home');
        }

        if ($store) {


            $response = array();
            $data = $request->all();

            $validator = Validator::make(
                $data,
                [
                    'edit_store_name' => ['required', ValidationRule::unique('stores', 'name')->ignore($store['id'], 'id')],
                    'edit_active' => 'required',
                    'edit_store_address' => 'required',
                ]
            );

            if ($validator->fails()) {
                $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
                $response['success'] = false;
                $response['messages'] = $validator->errors()->get('*');
            } else {
                // validation is true and we can store data

                $store->name = ucwords($data['edit_store_name']);
                $store->address = ucwords($data['edit_store_address']);
                $store->active = $data['edit_active'];

                $save  =  $store->save();
                if ($save) {
                    $response['success'] = true;
                    $response['messages'] = 'Store Updated succesfully.';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error! in the database while Updating the brand information.';
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
    public function destroy(store $store)
    {
        //
        if (!in_array('deleteStore', $this->get_user_permission())) {
            redirect('/home');
        }

        $response = array();
        if ($store && $store->id != 1) {
            $delete = $store->delete();
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = "Store deleted successfully.";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error! in the database while removing the brand information.";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page and try again.";
        }

        echo json_encode($response);
    }
}
