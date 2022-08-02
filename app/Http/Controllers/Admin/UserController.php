<?php


namespace App\Http\Controllers\Admin;


use App\DTO\SaveUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Models\User;
use App\Services\DatatableService;
use App\Services\UserService;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.users.index');
    }

    public function all(DatatableService $datatableService)
    {
        $users = $datatableService->userDatatable();
        return response($users);
    }

    public function create(User $user)
    {
        return view('admin.dashboard.users.edit', [
            'userId' => 0,
            'action' => route('admin.dashboard.users.update', 0),
            'heading' => 'Add User',
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.dashboard.users.edit', [
            'userId' => $user->id,
            'action' => route('admin.dashboard.users.update', $user->id),
            'heading' => 'Edit User',
            'user' => $user
        ]);
    }

    public function update(SaveUserRequest $request, $id, UserService $userService)
    {
        try {
            $userService->save(SaveUserDTO::fromRequest($request), $id);
            return redirect(route('admin.dashboard.users.index'))->with('status', ($id == 0) ? 'User added successfully.': 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response(['msg' => 'User deleted']);
        } catch (\Exception $e) {
            return response(['err' => $e->getMessage()]);
        }
    }

}
