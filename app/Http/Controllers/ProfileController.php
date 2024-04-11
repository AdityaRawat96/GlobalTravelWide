<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data["user"] = Auth::user();
        return view('profile.view')->with('data', $data);
    }

    public function updateProfileDetails(Request $request)
    {
        $user = Auth::user();
        $user_image = $user->avatar;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_file = $avatar->store('avatars', 'public');
            $user_image = $avatar_file;
        }

        $user_upated = User::where('id', $user->id)->update([
            'avatar' => $user_image,
            'first_name' => $request->all()["first_name"],
            'last_name' => $request->all()["last_name"],
            'phone' => $request->all()["phone"],
        ]);
        if ($user_upated) {
            $data["success"] = true;
            $data["response"] = "Profile updated successfully!";
        } else {
            $data["success"] = false;
            $data["response"] = "There was an error in updating your profile. Please try again!";
        }

        return $data;
    }


    public function updatePassword(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->all()["currentpassword"], $user->password)) {
            $user_updated = User::where('id', $user->id)->update([
                'password' => Hash::make($request->all()["password"]),
            ]);
            if ($user_updated) {
                $data["success"] = true;
                $data["response"] = "Password updated successfully!";
            } else {
                $data["success"] = false;
                $data["response"] = "There was an error in updating your profile. Please try again!";
            }
        } else {
            $data["success"] = false;
            $data["response"] = "Your current password is incorrect!";
        }
        return $data;
    }

    public function updateEmail(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->all()["confirmemailpassword"], $user->password)) {
            $user_updated = User::where('id', $user->id)->update([
                'email' => $request->all()["emailaddress"],
                'email_verified_at' => null
            ]);
            if ($user_updated) {
                $data["success"] = true;
                $data["response"] = "Email updated successfully!";
                $user = User::where('id', Auth::user()->id)->first();
                $user->sendEmailVerificationNotification();
            } else {
                $data["success"] = false;
                $data["response"] = "There was an error in updating your profile. Please try again!";
            }
        } else {
            $data["success"] = false;
            $data["response"] = "Your current password is incorrect!";
        }
        return $data;
    }
}
