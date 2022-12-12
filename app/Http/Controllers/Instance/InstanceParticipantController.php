<?php

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParticipantRequest;
use App\Models\Package;
use App\Models\PackageParticipant;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class InstanceParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->query('id') != "") {
            $id = Crypt::decrypt($request->query('id'));
            Session::put('package_id', $id);
        }
        $package_id = Session::get('package_id');
        $package = Package::findOrFail($package_id);
        $participants = PackageParticipant::where('package_id', $package_id)->get();
        $this->data['participants'] = $participants;
        $this->data['package'] = $package->name;
        return view('instance.participant.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['noreg'] = $this->generateKode();
        return view('instance.participant.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticipantRequest $request)
    {
        $params = $request->all();
        $params['no_reg'] = $this->generateKode();
        if ($request->has('photo')) {
            $params['photo'] = $this->simpanImage('participant', $request->file('photo'), $params['no_reg']);
        }
        $saved = false;
        $saved = DB::transaction(function () use ($params) {
            $package_id = Session::get('package_id');
            $participant = Participant::create($params);
            $participant->package()->sync($package_id);
            return true;
        });

        if ($saved) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('errors', 'Data Gagal Disimpan');
            // alert()->error('Error', 'Data Gagal Disimpan');
        }

        return redirect('instance/participant');
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
        $participant = PackageParticipant::findOrFail(Crypt::decrypt($id));
        $participants = Participant::findOrFail($participant->participant_id);
        $this->data['data'] = $participants;
        return view('instance.participant.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParticipantRequest $request, $id)
    {
        $params = $request->all();
        $participant = Participant::findOrFail(Crypt::decrypt($id));

        if ($request->has('photo')) {
            $params['photo'] = $this->simpanImage('participant', $request->file('photo'), $participant->no_reg);
        } else {
            $params = $request->except('photo');
        }
        $saved = false;
        $saved = DB::transaction(function () use ($participant, $params) {
            $package_id = Session::get('package_id');
            $participant->update($params);
            $participant->package()->sync($package_id);
            return true;
        });
        if ($saved) {
            alert()->success('Success', 'Data Berhasil Disimpan');
        } else {
            Session::flash('errors', 'Data Gagal Disimpan');
            // alert()->error('Error','Data Gagal Disimpan');
        }
        return redirect('instance/participant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $participant = Participant::findOrFail(Crypt::decrypt($id));
        $url = $participant->photo;
        $dir = public_path('storage/' . substr($url, 0, strrpos($url, '/')));
        $path = public_path('storage/' . $url);

        File::delete($path);

        rmdir($dir);
        if ($participant->delete()) {
            alert()->success('Success', 'Data Berhasil Dihapus');
        }
        return redirect('instance/participant');
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

    private function generateKode(){
        $jumlahRow = Participant::all()->count();
        $number = $jumlahRow + 1;
        $date = new DateTime();
        $timeNow = $date->format('dmy');
        $noreg = "REG-" . $timeNow . "-" . $number;
        return $noreg;
    }
}
