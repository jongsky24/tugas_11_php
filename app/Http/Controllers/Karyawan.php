<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\tbl_karyawan;

class Karyawan extends Controller
{
    public function getData()
    {
        $data = DB::table('tbl_karyawan')->get();
        if (count($data) > 0) {
            $res['message'] = "Success!";
            $res['value'] = $data;
            return response($res);
        } else {
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|max:2048'
        ]);

        $file = $request->file('file');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $tujuan_upload = 'foto';
        if ($file->move($tujuan_upload, $nama_file)) {
            $data = tbl_karyawan::create([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'umur' => $request->umur,
                'alamat' => $request->alamat,
                'foto' => $nama_file,
            ]);
            $res['message'] = "Success!";
            $res['values'] = $data;
            return response($res);
        } else {
            $res['message'] = "Failed!";
            return response($res);
        }
    }

    public function update(Request $request)
    {
        if (!empty($request->file)) {
            $this->validate($request, [
                'file' => 'required|max:2048'
            ]);

            $file = $request->file('file');

            $nama_file = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'foto';
            $file->move($tujuan_upload, $nama_file);
            $data = DB::table('tbl_karyawan')->where('id', $request->id)->get();
            foreach ($data as $karyawan) {
                @unlink(public_path('foto/' . $karyawan->foto));
                $ket = DB::table('tbl_karyawan')->where('id', $request->id)->update([
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'umur' => $request->umur,
                    'alamat' => $request->alamat,
                    'foto' => $nama_file,
                ]);
                $res['message'] = "Success!";
                $res['values'] = $ket;
                return response($res);
            }
        } else {
            $data = DB::table('tbl_karyawan')->where('id', $request->id)->get();
            foreach ($data as $karyawan) {
                $ket = DB::table('tbl_karyawan')->where('id', $request->id)->update([
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'umur' => $request->umur,
                    'alamat' => $request->alamat,
                ]);
                $res['message'] = "Success!";
                $res['values'] = $ket;
                return response($res);
            }
        }
    }

    public function hapus($id)
    {
        $data = DB::table('tbl_karyawan')->where('id', $id)->get();
        foreach ($data as $karyawan) {
            if (file_exists(public_path('foto/' . $karyawan->foto))) {
                @unlink(public_path('foto/' . $karyawan->foto));

                DB::table('tbl_karyawan')->where('id', $id)->delete();
                $res['message'] = "Success!";
                return response($res);
            } else {
                $res['message'] = "Empty!";
                return response($res);
            }
        }
    }

    public function getDetail($id)
    {
        $data = DB::table('tbl_karyawan')->where('id', $id)->get();
        if (count($data) > 0) {
            $res['message'] = "Success!";
            $res['value'] = $data;
            return response($res);
        } else {
            $res['message'] = "Empty!";
            return response($res);
        }
    }
}
