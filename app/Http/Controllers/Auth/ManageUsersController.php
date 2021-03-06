<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ManageUsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create()
    {
        return view('auth.create_user');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->save();

        return redirect('/admin/manage_users')->with("status", "The user account for $user->name has been updated");
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id, Request $request)
    {
        if (!empty($request->input('password'))) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);
        }

        $user = User::where('id', $id)->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }
        if ($request->input('is_admin')) {
            $user->is_admin = $request->input('is_admin');
        } else {
            $user->is_admin = 0;
        }

        $user->save();

        return redirect('/admin/manage_users')->with("status", "The user account for $user->name has been updated");
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        return view('auth.edit_user', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('auth.manage_users', compact('users'));
    }

}