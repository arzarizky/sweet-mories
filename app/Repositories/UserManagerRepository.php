<?php

namespace App\Repositories;

use App\Interfaces\UserManagerRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\File;


class UserManagerRepository implements UserManagerRepositoryInterface
{
    protected $relations = [
        'role',
    ];

    protected function generateFilename($file)
    {
        $pool1 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pool2 = 'ABCDEFGHIJKLMNOOQRSTUVWXYZ1234567890abcdefghijklmnopgrstuvwxyz';
        $random1 = substr(str_shuffle(str_repeat($pool1, 5)), 0, 8);
        $random2 = substr(str_shuffle(str_repeat($pool2, 5)), 0, 8);
        return $random1 . '-' . date('d-m-Y-H-i-s') . '-' . $random2 . '.' . $file->extension();
    }

    public function getAll($search, $page)
    {
        $model = User::with($this->relations);

        if ($search === null) {
            $query = $model->orderBy('updated_at','desc');
            return $query->paginate($page);
        } else {
            $query = $model
            ->whereHas('role', function ($query) use($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orWhere('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')

            ->orderBy('updated_at','desc');
            return $query->paginate($page);
        }
    }

    public function getTotalUser()
    {
        $totalUserAdmin = User::whereHas('role', function($query) { $query->where('name', 'Admin');})->count();
        $totalUserClient = User::whereHas('role', function($query) { $query->where('name', 'Client');})->count();
        return ['totalUserAdmin' => $totalUserAdmin, 'totalUserClient' => $totalUserClient];
    }

    public function getById($dataId)
    {
        return User::findOrFail($dataId);
    }

    public function create($dataDetails)
    {
        $dataDetails['avatar'] = $dataDetails['avatar'] ?? null;

        $avatar = $dataDetails['avatar'];

        if ($avatar != null) {
            $file = $dataDetails['avatar'];
            $filename = $this->generateFilename($file);
            $file->move(public_path('images/picture/avatar'), $filename);
            $dataDetails['avatar'] = $filename;
        }

        $getIDRoleAdmin = $adminRole = Role::where('name', 'admin')->first()->id;
        $dataDetails['role_id'] = $getIDRoleAdmin;
        $dataDetails['password'] = bcrypt($dataDetails['password']);

        User::create($dataDetails);
    }

    public function update($dataId, $newDetailsData)
    {
        $id = User::find($dataId);

        $newDetailsData['avatar'] = $newDetailsData['avatar'] ?? $id->avatar;

        if ($newDetailsData['avatar'] != $id->avatar) {

            $oldImagePath = public_path('images/picture/avatar/' . $id->avatar);

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $file = $newDetailsData['avatar'];
            $filename = $this->generateFilename($file);
            $file->move(public_path('images/picture/avatar'), $filename);
            $newDetailsData['avatar'] = $filename;
        }

        $id->update($newDetailsData);
    }

    public function updatePassword($dataId, $newDetailsData)
    {
        $newDetailsData['password'] = bcrypt($newDetailsData['password']);
        User::whereId($dataId)->update($newDetailsData);
    }

    public function delete($dataId)
    {
        $id = User::find($dataId);

        if ($id->avatar != null) {
            $oldImagePath = public_path('images/picture/avatar/' . $id->avatar);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        $id->delete();
    }
}
