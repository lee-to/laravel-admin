<?php

namespace Leeto\Admin\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {

		return view('admin::index.index');
	}

    public function login(Request $request)
    {
        if(Auth::guard('admin')->check()) {
            return redirect(route('admin.index'));
        }

        if($request->isMethod('post')) {
            $credentials = $request->only(['email', 'password']);
            $remember = $request->get('remember', false);

            if(Auth::guard('admin')->attempt($credentials, $remember)) {
                return redirect(url()->previous());
            } else {
                $request->session()->flash('alert', __('admin.login.notfound'));

                return back()->withInput()->withErrors(['login' => __('admin.login.notattempt')]);
            }
        }


        return view('admin::index.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect(route('admin.login'));
    }

    public function attachments(Request $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');

            return ['attachment' => Storage::url($file->store('attachments', 'public'))];
        }
    }
}
