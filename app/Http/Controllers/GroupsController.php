<?php

namespace App\Http\Controllers;

use App\Groups;
use App\User;
use Illuminate\Validation\Rule as ValidationRule;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function index()
    {
        if (!in_array('viewGroup', $this->get_user_permission())) {
            return redirect('/home');
        }

        return view('groups.index')->with('groups_data', Groups::all()->except(1));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!in_array('createGroup', $this->get_user_permission())) {
            return redirect('/home');
        }
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (!in_array('createGroup', $this->get_user_permission())) {
            return redirect('/home');
        }
        $this->validate(request(), [
            'group_name' => 'required|unique:groups',
            'permission' => 'required'
        ]);
        $group = new Groups();
        $data = request()->all();

        $group->group_name = ucwords($data['group_name']);
        $group->permission = serialize($data['permission']);

        $group->save();
        session()->flash('success', 'group created successfully');
        return redirect('/group');
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
    public function edit(Groups $group)
    {
        if (!in_array('updateGroup', $this->get_user_permission())) {
            return redirect('/home');
        }
        $serialize_permission = unserialize($group['permission']);

        return view('groups.edit')->with('group_data', $group)->with('serialize_permission', $serialize_permission);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Groups $group)
    {
        $data = request()->all();
        if (!in_array('updateGroup', $this->get_user_permission())) {
            return redirect('/home');
        }
        $this->validate(request(), [
            'group_name' => ['required', ValidationRule::unique('groups')->ignore($group['id'], 'id')],
            'permission' => 'required'
        ]);


        $permission = serialize($data['permission']);
        $group->group_name = ucwords($data['group_name']);
        $group->permission = $permission;

        $group->save();
        session()->flash('success', 'group updated successfully');
        return redirect('/group');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Groups $group)
    {
        if (!in_array('deleteGroup', $this->get_user_permission())) {
            return redirect('/home');
        }

        $group->delete();
        session()->flash('success', 'group deleted successfully.');
        return redirect('/group');
    }
}
