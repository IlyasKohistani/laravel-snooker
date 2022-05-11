<?php

namespace App\Http\Controllers;

use App\Groups;
use App\Store;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permission = $this->get_user_permission();

        if (!in_array('viewUser', $permission)) {
            redirect('/home');
        }
        $user_id = auth()->user()->id;
        $user_data = User::with('group')->get()->except([1, $user_id]);

        $result = array();
        foreach ($user_data as $k => $v) {

            $result[$k]['user_info'] = $v;

            $group = $v->group;

            $result[$k]['user_group'] = $group;
        }


        return view('users.index')->with('user_data', $result)->with('user_permission', $permission);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!in_array('updateUser', $this->get_user_permission())) {
            return  redirect('/home');
        }


        $store_data =  store::all();
        $group_data = groups::all()->except(1);


        return view('users.create')->with('store_data', $store_data)->with('group_data', $group_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        if (!in_array('createUser', $this->get_user_permission())) {
            redirect('/home');
        }
        $data = request()->all();

        $validator = Validator::make(
            $data,
            [
                'username' => 'bail|required|unique:users',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|min:10|email|unique:users',
                'phone' => 'required|min:10',
                'group' => 'required',
                'store' => 'required',
                'password' => 'required|confirmed|min:8',
                'gender' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect('users/create')->withErrors($validator->getMessageBag()->first());
        }

        $user = new User();
        $user->username = $data['username'];
        $user->password = Hash::make($data['password']);
        $user->email = $data['email'];
        $user->firstname = ucwords($data['firstname']);
        $user->lastname = ucwords($data['lastname']);
        $user->phone = $data['phone'];
        $user->gender = $data['gender'];
        $user->store_id = $data['store'];
        $user->group_id = $data['group'];

        $save = $user->save();

        if ($save) {

            session()->flash('success', 'User created successfully.');
            return redirect('/users');
        } else {
            session()->flash('success', 'Something went wrong. please try again!');
            redirect('users/create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();

        $group = $user->group;
        $permission = unserialize($group['permission']);

        if (!in_array('viewProfile', $permission)) {
            return redirect('/home');
        }
        return view('users.profile')->with('user_data', $user)->with('user_group', $group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user_data)
    {

        if (!in_array('updateUser', $this->get_user_permission())) {
            return redirect('/home');
        }



        if (!isset($user_data) || $user_data->id == 1) {
            return redirect('/home');
        }

        $user_group = $user_data->group;

        $store_data = Store::all();

        $group_data = Groups::all()->except(1);
        $data = [
            'user_data' => $user_data,
            'group_data' => $group_data,
            'store_data' => $store_data,
            'user_group' => $user_group
        ];


        return view('users.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        if (!in_array('updateUser', $this->get_user_permission())) {
            return redirect('/home');
        }

        $data = request()->all();
        $rules = [
            'username' => ['required', ValidationRule::unique('users')->ignore($user->id, 'id')],
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => ['required', 'email', 'min:10', ValidationRule::unique('users')->ignore($user->id, 'id')],
            'phone' => 'required|min:10',
            'group' => 'required',
            'store' => 'required',
            'gender' => 'required',
        ];
        $validator = Validator::make(
            $data,
            $rules

        );



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag()->first());
        }
        if (empty($data['password']) && empty($data['password_confirmation'])) {
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->firstname = ucwords($data['firstname']);
            $user->lastname = ucwords($data['lastname']);
            $user->phone = $data['phone'];
            $user->gender = $data['gender'];
            $user->store_id = $data['store'];
            $user->group_id = $data['group'];

            $save = $user->save();

            if ($save) {
                session()->flash('success', 'User successfully updated.');
                return  redirect('/users');
            } else {
                session()->flash('errors', 'Error occurred!!');
                return redirect()->back();
            }
        } else {
            $rules = [
                'password' => 'bail|required|confirmed|min:8'
            ];

            $validate =  $this->validate(request(), $rules);

            if ($validate) {

                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->firstname = ucwords($data['firstname']);
                $user->lastname = ucwords($data['lastname']);
                $user->phone = $data['phone'];
                $user->gender = $data['gender'];
                $user->store_id = $data['store'];
                $user->group_id = $data['group'];
                $user->password = hash::make($data['password']);

                $save = $user->save();

                if ($save) {
                    session()->flash('success', 'User successfully updated.');
                    return  redirect('/users');
                } else {
                    session()->flash('errors', 'Error occurred!!');
                    return redirect()->back();
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            session()->flash('success', 'User Deleted successfully');
            return redirect('/users');
        }
    }


    public function setting()
    {
        $user = Auth::user();

        $group = $user->group;
        $permission = unserialize($group['permission']);

        if (!in_array('updateSetting', $permission)) {
            return redirect('/home');
        }

        return view('users.setting')->with('user_data', $user)->with('user_group', $group);
    }

    /**
     * update the specified resource from storage.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */


    public function updateSetting()
    {
        $id = Auth::user()->id;
        $data = request()->all();

        $rules = [
            'username' => ['required', ValidationRule::unique('users')->ignore($id, 'id')],
            'email' => ['required', 'email', 'min:10', ValidationRule::unique('users')->ignore($id, 'id')],
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required|min:10',
            'gender' => 'required',
        ];
        $validator = Validator::make(
            $data,
            $rules

        );



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag()->first());
        }

        if (empty($data['password']) && empty($data['password_confirmation'])) {
            $user = User::find($id);
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->firstname = ucwords($data['firstname']);
            $user->lastname = ucwords($data['lastname']);
            $user->phone = $data['phone'];
            $user->gender = $data['gender'];

            $save = $user->save();

            if ($save) {
                session()->flash('success', 'Setting successfully updated.');
                return  redirect()->back();
            } else {
                session()->flash('errors', 'Pleasae! Refresh the page and try again.');
                return redirect()->back();
            }
        } else {
            $rules = [
                'password' => 'bail|required|confirmed|min:8'
            ];

            $validate =  $this->validate(request(), $rules);

            if ($validate) {

                $user = User::find($id);
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->firstname = ucwords($data['firstname']);
                $user->lastname = ucwords($data['lastname']);
                $user->phone = $data['phone'];
                $user->gender = $data['gender'];
                $user->password = hash::make($data['password']);

                $save = $user->save();

                if ($save) {
                    session()->flash('success', 'Setting successfully updated.');
                    return  redirect()->back();
                } else {
                    session()->flash('errors', 'Error occurred!!');
                    return redirect()->back();
                }
            }
        }
    }
}
