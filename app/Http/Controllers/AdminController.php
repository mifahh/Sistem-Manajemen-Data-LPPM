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
        $data_abdimas = \App\Models\Abdimas::All();
        $jml_abdimas = $data_abdimas->count();

        $data_publikasi = \App\Models\Publikasi::All();
        $jml_publikasi = $data_publikasi->count();

        $data_ki = \App\Models\KI::All();
        $jml_ki = $data_ki->count();

        return view('admin.dashboard', [
            'jml_abdimas' => $jml_abdimas,
            'jml_publikasi' => $jml_publikasi,
            'jml_ki' => $jml_ki,
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
