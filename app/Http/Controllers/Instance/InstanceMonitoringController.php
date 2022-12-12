<?php

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Package;
use App\Models\PackageParticipant;
use App\Models\Participant;
use GuzzleHttp\Client;
use Hamcrest\Core\IsNot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Nette\Utils\DateTime;

class InstanceMonitoringController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->query('id') != "") {
    //         $id = Crypt::decrypt($request->query('id'));
    //         Session::put('id', $id);
    //     }
    //     if ($request->query('logID') != "") {
    //         $logID = Crypt::decrypt($request->query('logID'));
    //         Session::put('logID', $logID);
    //     }
    //     $id = Session::get('id');
    //     $logID = Session::get('logID');

    //     // $data = Participant::findOrFail($id);
    //     // $logs = Participant::select('logs.*')->join('logs', 'logs.no_peserta', '=', 'participants.no_identity')->where('participants.id', $id)->get();
    //     // if ($logID != "") {
    //     //     $logData = Log::findOrFail($logID);
    //     //     $this->data['image1'] = $this->simpanImage($logData->base64_head_gest, $data->name);
    //     //     $this->data['image2'] = $this->simpanImage($logData->base64_obj_det, $data->name);
    //     // } else {
    //     //     $this->data['image1'] = '';
    //     //     $this->data['image2'] = '';
    //     // }
    //     // $this->data['data'] = $data;
    //     // $this->data['logs'] = $logs;
    //     return view('instance.monitoring.image', $this->data);
    // }

    public function index(Request $request)
    {

        if ($request->query('id') != "") {
            $id = Crypt::decrypt($request->query('id'));
            Session::put('participant_id', $id);
        }
        $participant_id = Session::get('participant_id');
        $data = Participant::findOrFail($participant_id);
        $package_id = Session::get('package_id');
        $participants = PackageParticipant::where('package_id', $package_id)->get();
        $code = Package::findOrFail($package_id);
        $this->data['logs'] = [];
        $this->data['data'] = $data;
        $this->data['code'] = $code->code;
        $this->data['participants'] = $participants;
        return view('instance.monitoring.index', $this->data);
    }

    public function getPackage()
    {
        $packages = Package::where('instance_id', '=', auth()->user()->instance->id)->get();
        $this->data['packages'] = $packages;
        $date = new DateTime();
        $timeNow = $date->format('Y-m-d\TH:i');
        $this->data['time'] = $timeNow;
        return view('instance.monitoring.package', $this->data);
    }

    public function getParticipant(Request $request)
    {

        if ($request->query('id') != "") {
            $id = Crypt::decrypt($request->query('id'));
            Session::put('package_id', $id);
        }
        $package_id = Session::get('package_id');
        $participants = PackageParticipant::where('package_id', $package_id)->get();
        $code = Package::findOrFail($package_id);
        $this->data['code'] = $code->code;
        $this->data['name'] = $code->name;
        $this->data['participants'] = $participants;
        return view('instance.monitoring.participant', $this->data);
    }

    private function simpanImage($foto, $nama)
    {
        $image = str_replace('data:image/png;base64,', '', $foto);
        $image = str_replace(' ', '+', $image);
        $dt = new DateTime();

        $path = public_path('storage/uploads/monitoring/base64/' . $dt->format('Y-m-d') . '/' . $nama);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $file = base64_decode($image);
        $name =  'base64_' . $nama . '_' . $dt->format('Y-m-d');
        $fileName = $name . '.png';
        $folder = 'uploads/monitoring/base64/' . $dt->format('Y-m-d') . '/' . $nama;

        $check = public_path($folder) . $fileName;

        if (File::exists($check)) {
            File::delete($check);
        }
        File::put(public_path('storage/uploads/monitoring/base64/' . $dt->format('Y-m-d') . '/' . $nama) . '/' . $fileName, $file);
        // $filePath = $file->storeAs($folder, $fileName, 'public');
        return $folder . '/' . $fileName;
    }

    public function getDataParticipant($idparticipant, $idpackage)
    {
        $client = new Client();
        $url = "http://expro.polindra.ac.id/api/trust-score/" . $idpackage . "/" . $idparticipant;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
        return $responseBody;
    }
}
