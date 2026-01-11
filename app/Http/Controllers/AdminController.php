<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //dashboard
    public function dashboard()
    {
        $jml_abdimas = \App\Models\Abdimas::where('deleted_at', null)->get()->count();
        $jml_penelitian = \App\Models\Penelitian::where('deleted_at', null)->get()->count();
        $jml_publikasi = \App\Models\Publikasi::where('deleted_at', null)->get()->count();
        $jml_ki = \App\Models\KI::where('deleted_at', null)->get()->count();

        $jml_mhs = \App\Models\DataMahasiswa::where('deleted_at', null)->get()->count();
        $jml_dosen = \App\Models\DataDosen::where('deleted_at', null)->get()->count();

        return view('admin.dashboard', [
            'jml_abdimas' => $jml_abdimas,
            'jml_penelitian' => $jml_penelitian,
            'jml_publikasi' => $jml_publikasi,
            'jml_ki' => $jml_ki,
            'jml_mhs' => $jml_mhs,
            'jml_dosen' => $jml_dosen,
        ]);
    }

    //kalendar
    public function index(Request $request)
    {
  //dd($request->all());
        if($request->ajax()) {

             $data = DB::table('events')->whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
//   dd($data);
             return response()->json($data);
        }

        return view('admin.Manajemen.kalender_ppm');
    }
    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $event = DB::table('events')->insert([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json($event);

            case 'update':
                DB::table('events')->where('id', $request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);
                return response()->json(['status' => 'updated']);

            case 'delete':
                DB::table('events')->where('id', $request->id)->delete();
                return response()->json(['status' => 'deleted']);

            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }
    }
}
