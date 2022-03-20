<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SendEmailController;
use App\Models\Course;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', ['users' => User::all()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    //public function store(Request $request)
        public function store()
    {

//        $request->validate([
//            'name' => ['required', 'max:255'],
//            'role' => ['required', 'max:20'],
//            'job' => ['nullable', 'max:255'],
//            'employer' => ['nullable', 'max:255'],
//            'bio' => ['nullable'],
//            'email' => ['required', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'confirmed', Rules\Password::defaults()]
//        ]);

            $formData = request()->validate([
                'name' => 'required|max:255',
                'role' => 'required|max:20',
                'job' => 'nullable|max:255',
                'employer' => 'nullable|max:255',
                'bio' => 'nullable',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed',
            ]);
            $formData['password'] = Hash::make($formData['password']);
            //dd($formData);
            try {
                $user = User::create($formData);
//        $user = User::create([
//            'name' => $request->name,
//            'role' => $request->role,
//            'job' => $request->job,
//            'employer' => $request->employer,
//            'bio' => $request->bio,
//            'email' => $request->email,
//            'password' => Hash::make($request->password)
//        ]);

                if ($user) {
                    event(new Registered($user));
                    //Auth::login($user);
                    //return redirect(RouteServiceProvider::HOME);__('Learning Objects Repository').' - '.__('Account details')
                    //SendEmailController::notify($formData['email'],request('password'));
                    SendEmailController::notify(__('Learning Objects Repository').' - '.__('Account details'),'','auth.notify',['username'=>request('email'), 'password'=>request('password')]);
                    return redirect(route('register', app()->getLocale()))->with('success', 'The new user [' . $user->name . '] has been added');
                } else return back()->withInput();
            } catch (QueryException $exception) {
                return redirect(route('register', app()->getLocale()))->with('fail', 'There is an existed user for the same email');
            }

    }

    public function findUser()
    {
        $user = User::all()->where('id', '=', request('uid'));
        return view('auth.register', [
            'user' => $user
        ]);
    }

    public function updateUser(){

        $formData =request()->validate([
            'name' => 'required|max:255',
            'role' => 'required|max:20',
            'job' => 'nullable|max:255',
            'employer' => 'nullable|max:255',
            'bio' => 'nullable'
        ]);

        if(!empty(request('password'))) $formData['password'] = Hash::make(request('password'));
        try {
            if (User::where('id', request('user_id'))->update($formData)) {
                //SendEmailController::notify(request('email'),request('password'));
                SendEmailController::notify(__('Learning Objects Repository').' - '.__('Account details'),'','auth.notify',['username'=>request('email'), 'password'=>request('password')]);
                return redirect(route('register', app()->getLocale()))->with('success', 'The user (' . $formData['name'] . ') has been updated');
            }
            return back()->withInput();
        } catch (QueryException $exception) {
            return redirect(route('register', app()->getLocale()))->with('fail', 'There is an existed user for the same email');
        }
    }

    public function deleteUser()
    {
        $course = Course::all()->where('course_sm_expert', '=', request('uid'));
        $user = User::all()->where('id', '=', request('uid'));
        foreach($user as $data){
            $name = $data->name;
        }

        try {
            if ($course->count() <= 0) {
                User::where('id', '=', request('uid'))->delete();
                return redirect(route('register', app()->getLocale()))->with('success', 'The user (' . $name . ') has been deleted');
            }
            return back()->with('fail', 'The user (' . $name . ') cannot be deleted, because he is assigned courses');
        } catch (QueryException $exception) {
            return back()->with('fail', 'The user has not been deleted');
        }

    }


}
