<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Admin;
use App\Asset;
use App\Category;
use App\Building;
use App\Region;
use App\User;
use Mockery\Exception;
use App\Http\Controllers\AdminBaseController;
use App\Jobs\ProcessImage;
use File;


class AdminController extends AdminBaseController
{

    public function index() {
        $user = Admin::getName(cas()->user());
        $assetCount = Asset::count();
        $categoryCount = Category::count();
        $buildingCount = Building::count();
        $regionCount = Region::count();
        $userCount = User::count();

        return view('admin.main',
            [
                'user' => $user,
                'assetCount' => $assetCount,
                'categoryCount' => $categoryCount,
                'buildingCount' => $buildingCount,
                'regionCount' => $regionCount,
                'userCount' => $userCount
            ]
        );
    }

    public function store() {
        $admin = new Admin();

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:admins',
            'image' => 'image'
        ]);

        try {
            $path = false;
            if(request('image') != null) {
                $path = $request->file('image')->store(
                    'pictures/', 'public'
                );
            }

        }
        catch(Exception $e) {
            \Session::flash('flash_deleted',request('name') . ' Error uploading file');
            return redirect('/admin/users');
        }


            $admin->first_name = request('first_name');
            $admin->last_name = request('last_name');
            $admin->email = request('email');
            $admin->username = request('username');

            if($path) {
                $admin->picture = $path;
                ProcessImage::dispatch($path, 500, 60);
            }

            $admin->save();

            \Session::flash('flash_created', request('username') . ' has been created');
            return redirect('/admin/users');

    }

    public function show() {
        $users = Admin::where('deleted_at', '=', null)->paginate(25);
        return view('admin.users.users',
            [
                'users' => $users
            ]
        );
    }

    public function create() {
        return view('admin.users.usersCreate');
    }

    public function edit($id)
    {
        $user = Admin::find($id);
        return view('admin.users.usersEdit',
            [
                'user' => $user
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $this->validate(request(), [
            'id' => 'exists:admins',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'username' => 'required|exists:admins',
            'image' => 'image'
        ]);



        try {
            $path = false;
            if(request('image') != null) {
                $path = $request->file('image')->store(
                    'pictures/', 'public'
                );
            }

        }
        catch(Exception $e) {
            \Session::flash('flash_deleted',request('name') . ' Error uploading file');
            return redirect('/admin/users');
        }

        try {
            $admin = Admin::find($id);
            $admin->first_name = request('first_name');
            $admin->last_name = request('last_name');
            $admin->email = request('email');
            if($path) {
                if($admin->picture != null) {
                    File::delete(public_path(). '/storage/' .$admin->picture);
                }
                $admin->picture = $path;
                ProcessImage::dispatch($path, 500, 60);
            }


            $admin->save();

            \Session::flash('flash_created', request('username') . ' has been edited');
            return redirect('/admin/users');
        } catch (QueryException $e) {
            \Session::flash('flash_deleted', 'Error Editing Admin');
            return redirect('/admin/users');
        }

    }

    public function destroy($id)
    {
        try {
            $admin = Admin::find($id);
            $user = $admin->username;


            $admin->deleted_at = date('Y-m-d H:i:s');
            $admin->save();

            \Session::flash('flash_deleted', $user . ' has been deleted');
            return redirect('/admin/users');
        } catch (QueryException $e) {
            \Session::flash('flash_deleted', 'Error Deleting Admin');
            return redirect('/admin/users');
        }
    }
}
