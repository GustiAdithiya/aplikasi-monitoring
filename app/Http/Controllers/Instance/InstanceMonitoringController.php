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
}
