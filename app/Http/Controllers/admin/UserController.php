<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\JobList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)
            ->latest()
            ->paginate(4);
        // dd($users);
        return view('admin.user.index', compact('users'));
    }

    public function show(User $user)
    {
        $activeJobsCount = JobList::where('user_id', $user->id)
            ->where('available', '1')
            ->count();
        // dd($activeJobsCount);
        return view('admin.user.show', compact('user', 'activeJobsCount'));
    }

    public function destroy(User $user){
        $userId = $user->id;
        $user->delete();
        JobList::where('user_id',$userId)->delete();
        $message = 'User #' . $userId . ' and related Jobs are now deleted!';
        return redirect()->route('admin#userList')->with('message',$message);
    }
}
