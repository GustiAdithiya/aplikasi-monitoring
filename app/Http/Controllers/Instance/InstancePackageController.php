<?php

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class InstancePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::where('instance_id','=',auth()->user()->instance->id)->get();
        $this->data['packages'] = $packages;
        $date = new DateTime();
        $timeNow = $date->format('Y-m-d\TH:i');
        $this->data['time'] = $timeNow;
        return view('instance.package.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('instance.package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $params = $request->all();
        $params['instance_id'] = auth()->user()->instance->id;
        if (Package::create($params)) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('errors', 'Data Gagal Disimpan');
            // alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect('instance/package');
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
        $package = Package::findOrFail(Crypt::decrypt($id));
        $this->data['data'] = $package;
        return view('instance.package.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PackageRequest $request, $id)
    {
        $params = $request->all();
        $params['instance_id'] = auth()->user()->instance->id;
        $package = Package::findOrFail(Crypt::decrypt($id));
        if ($package->update($params)) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('errors', 'Data Gagal Disimpan');
            // alert()->error('Error', 'Data Gagal Disimpan');
        }
        return redirect('instance/package');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::findOrFail(Crypt::decrypt($id));
        if ($package->delete()) {
            alert()->success('Success', 'Data Berhasil Dihapus');
        }
        return redirect('instance/package');
    }
}
