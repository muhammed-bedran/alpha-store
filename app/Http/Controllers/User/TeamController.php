<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeamController extends Controller
{
    //
    public function index()
    {
        $store = Auth::user()->store;
        $members = $store->users()->paginate();
        return view('user.pages.team.index', compact('members', 'store'));
    }
    public function create()
    {
        $member = new User();
        return view('user.pages.team.create', compact('member'));
    }
    public function store(Request $request)
    {
        $store = Auth::user()->store;
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            'store_id' => $store->id
        ]);
        return redirect()->route('user.team.index')
            ->with('success', 'Member created successfully');
    }
    public function edit(User $member)
    {
        $this->authorizeMember($member);
        return view('user.pages.team.edit', compact('member'));
    }
    public function update(Request $request, User $member)
    {
        $this->authorizeMember($member);
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $member->name = $data['name'];
        $member->email = $data['email'];
        if (!empty($data['password'])) {
            $member->password = Hash::make($data['password']);
        }
        return redirect()->route('user.team.index')
            ->with('success', 'Member updated successfully');
    }
    public function destroy(User $member)
    {
        $this->authorizeMember($member);
        $member->delete();
        return redirect()->route('user.team.index')
            ->with('success', 'Member deleted successfully');
    }
    private function authorizeMember(User $member) {
        if($member->store_id !== Auth::user()->store->id) {
            abort(403);
        }
    }
}
