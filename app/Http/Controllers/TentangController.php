<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TentangController extends Controller
{
    //profil
    public function profil()
    {
        $data_user = DB::table('users')->where('id', Auth::user()->id)
        ->get();
        // dd($data_user);
        return view('tentang.profil',[
            'data_user' => $data_user
        ]);
    }
    public function kerjasama()
    {
        return view('tentang.kerjasama');
    }
    public function data_kerjasama()
    {
        return view('tentang.data_kerjasama');
    }
    //kalendar
    public function tanggal(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {

            $data = DB::table('events')->whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            //   dd($data);
            return response()->json($data);
        }

        return view('tentang.kalender_ppm');
    }
    public function ajax(Request $request)
    {
        //dd($request->all());
        switch ($request->type) {
            case 'add':
                $event = DB::table('events')->create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);

            case 'update':
                $event = DB::table('events')->find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);

            case 'delete':
                $event = DB::table('events')->find($request->id)->delete();

                return response()->json($event);

            default:
                # code...
                break;
        }
    }
}
