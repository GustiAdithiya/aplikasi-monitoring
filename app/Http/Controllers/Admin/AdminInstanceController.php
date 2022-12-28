<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstanceRequest;
use App\Http\Requests\UserRequest;
use App\Models\Instance;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class AdminInstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instances = Instance::all();
        $this->data['instances'] = $instances;
        return view('admin.instance.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.instance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstanceRequest $request)
    {
        try {
            $params = $request->all();
            $params['password'] =  Hash::make($request->password);
            $params['role'] = 'instance';

            if ($request->has('photo')) {
                $params['photo'] = $this->simpanImage('instance', $request->file('photo'), $params['username']);
            }

            $user = User::create($params);
            if ($user) {
                $params['user_id'] = $user->id;
                if (Instance::create($params)) {
                    alert()->success('Success', 'Data Berhasil Disimpan');
                } else {
                    $user = User::findOrFail($user->id);
                    $user->delete();
                    Session::flash('errors', 'Data Gagal Disimpan');
                    // alert()->error('Error', 'Data Gagal Disimpan');
                }
            }
            return redirect('admin/instance');
        } catch (\Throwable $th) {
            Session::flash('errors', 'Data Gagal Disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instance = Instance::findOrFail(Crypt::decrypt($id));
        $this->data['data'] = $instance;
        return view('admin.instance.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstanceRequest $request, $id)
    {
        try {
            $params = $request->all();
            $params['username'] = $request->username;

            if ($request->filled('password')) {
                $params['password'] = Hash::make($request->password);
            } else {
                $params = $request->except('password');
            }

            if ($request->has('photo')) {
                $params['photo'] = $this->simpanImage('instance', $request->file('photo'), $params['username']);
            } else {
                $params = $request->except('photo');
            }

            $instance = Instance::findOrFail(Crypt::decrypt($id));
            $user = User::findOrFail($instance->user_id);
            if ($instance->update($params) && $user->update($params)) {
                alert()->success('Success', 'Data Berhasil Disimpan');
            } else {
                Session::flash('errors', 'Data Gagal Disimpan');
                // alert()->error('Error','Data Berhasil Disimpan');
            }
            return redirect('admin/instance');
        } catch (\Throwable $th) {
            Session::flash('errors', 'Data Gagal Disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $instance = Instance::findOrFail(Crypt::decrypt($id));
            $url = $instance->photo;
            $dir = public_path('storage/' . substr($url, 0, strrpos($url, '/')));
            $path = public_path('storage/' . $url);

            File::delete($path);

            rmdir($dir);
            if ($instance->delete()) {
                $user = User::findOrFail($instance->user_id);
                $user->delete();
                alert()->success('Success', 'Data Berhasil Dihapus');
            }
            return redirect('admin/instance');
        } catch (\Throwable $th) {
            Session::flash('errors', 'Data Gagal Dihapus');
        }
    }

    private function simpanImage($type, $foto, $nama)
    {
        $dt = new DateTime();

        $path = public_path('storage/uploads/profil/' . $type . '/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = $foto;
        $name =  $type . '_' . $nama . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.' . $file->getClientOriginalExtension();
        $folder = '/uploads/profil/' . $type . '/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }

        $filePath = $file->storeAs($folder, $fileName, 'public');
        return $filePath;
    }
}
