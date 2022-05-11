<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = $this->get_user_permission();
        if (!in_array('viewCategory', $permission)) {
            return    redirect('/home');
        }

        return view('category.index')->with('user_permission', $permission);
    }

    public function fetchData()
    {
        $permission = $this->get_user_permission();
        if (!in_array('viewCategory', $permission)) {
            return    redirect('/home');
        }

        $result = array('data' => array());

        $data = Category::all();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if (in_array('updateCategory', $permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }

            if (in_array('deleteCategory', $permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['name'],
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
        $response = array();


        if (!in_array('createCategory', $this->get_user_permission())) {
            return redirect('/home');
        }

        $response = array();
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'category_name' => 'unique:categories,name|required',
                'active' => 'required',
            ]
        );

        if ($validator->fails()) {
            $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
            $response['success'] = false;
            $response['messages'] = $validator->errors()->get('*');
        } else {
            $category = new Category();
            $category->name = ucwords($data['category_name']);
            $category->active = $data['active'];
            $create = $category->save();
            if ($create) {
                $response['success'] = true;
                $response['messages'] = 'Category created succesfully.';
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (!in_array('updateCategory', $this->get_user_permission())) {
            return redirect('/home');
        }
        if ($category) {
            echo json_encode($category);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $response = array();


        if (!in_array('updateCategory', $this->get_user_permission())) {
            return redirect('/home');
        }

        $response = array();
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'edit_category_name' => 'unique:categories,name,' . $category['id'] . ',id|required',
                'edit_active' => 'required',
            ]
        );

        if ($validator->fails()) {
            $validator->getMessageBag()->setFormat('<p class="text-danger">:message</p>');
            $response['success'] = false;
            $response['messages'] = $validator->errors()->get('*');
        } else {
            $category->name = ucwords($data['edit_category_name']);
            $category->active = $data['edit_active'];
            $create = $category->save();
            if ($create) {
                $response['success'] = true;
                $response['messages'] = 'Updated created succesfully.';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }
        }


        echo json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!in_array('deleteCategory', $this->get_user_permission())) {
            redirect('/home');
        }

        $response = array();
        if ($category) {
            $delete = $category->delete();
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = "Category deleted successfully.";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error! in the database while removing the brand information.";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page and try again!";
        }

        echo json_encode($response);
    }
}
