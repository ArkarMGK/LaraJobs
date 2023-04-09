<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Company;
use App\Models\JobList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function dashboard()
    {
        $activeJobsCount = JobList::where('available', '1')->count();
        // LAST ID TO COUNT TOTAL JOBS POSTED
        $totalJobsCount = JobList::get()->last();
        $totalJobsCount = $totalJobsCount->id;
        $hiredJobsCount = $totalJobsCount - $activeJobsCount;

        $numberOfUsers = User::where('id', '!=', Auth::user()->id)->count();
        $numberOfCompanies = Company::count();
        return view(
            'admin.dashboard',
            compact(
                'totalJobsCount',
                'hiredJobsCount',
                'numberOfUsers',
                'numberOfCompanies'
            )
        );
    }

    public function profile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // dd($user->toArray());
        return view('admin.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);
        User::where('id', Auth::user()->id)->update($data);
        return back()->with('message', 'Admin Name has been updated');
    }

    public function updatePassword(Request $request)
    {
        // dd($request->all());
        $this->passwordValidationCheck($request);
        $user = User::where('id', Auth::user()->id)->first();

        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $dbHashedPassword = $user->password;
        $hashedNewPassword = Hash::make($newPassword);

        // dd($dbHashedPassword);
        // Check Old Passwords and Update
        if (Hash::check($oldPassword, $dbHashedPassword)) {
            User::where('id', Auth::user()->id)->update([
                'password' => $hashedNewPassword,
            ]);
            // Auth::logout();
            return redirect()->route('admin#profile')->with(['message' => 'Password already Updated']);
        }
        return back()->with([
            'message' => 'The Old Password Not Match.Try Again!',
        ]);
    }

    private function passwordValidationCheck($request)
    {
        $validationRules = [
            'oldPassword' => 'required|min:8|max:16',
            'newPassword' => 'required|min:8|max:16',
            'confirmPassword' => 'required|min:8|max:16|same:newPassword',
        ];
        Validator::make($request->all(), $validationRules)->validate();
    }
}
