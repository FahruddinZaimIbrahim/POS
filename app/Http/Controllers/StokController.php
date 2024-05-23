<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\StokModel;
use illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list'  => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        $user = UserModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);

    }
    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'user_id', 'barang_id', 'stok_tanggal', 'stok_jumlah')->with(['user', 'barang']);
        if ($request->user_id) {
            $stoks->where('user_id', $request->user_id);
        }

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('action', function ($stok) {
                $btn = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/stok/'.$stok->stok_id).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure to delete this data?\');">Delete</button></form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);    
        }
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah stook baru',
        ];
        $users = UserModel::all();
        $barangs = BarangModel::all();
        $activeMenu = 'stok';

        return view('stok.create', compact('breadcrumb', 'page','users','barangs', 'activeMenu'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);

        StokModel::create([
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id,
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function edit($id)
    {
    $stok = StokModel::find($id);
    $users = UserModel::all();
    $barangs = BarangModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Stok',
        'list' => ['Home', 'Stok', 'Edit']
    ];

    $page = (object) [
        'title' => 'Edit stok',
    ];

    $activeMenu = 'stok';

    return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'users', 'barangs', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'barang_id' => 'required|exists:barangs,id',
        'stok_tanggal' => 'required|date',
        'stok_jumlah' => 'required|integer|min:0',
    ]);

    StokModel::find($id)->update([
        'user_id' => $request->user_id,
        'barang_id' => $request->barang_id,
        'stok_tanggal' => $request->stok_tanggal,
        'stok_jumlah' => $request->stok_jumlah,
    ]);

    return redirect('/stok')->with('success', 'Data stok berhasil diubah');
}
    public function show(string $id)
    {
    $stok = StokModel::find($id);

    $breadcrumb = (object) [
        'title' => 'Detail Stok',
        'list' => ['Home', 'Stok', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Stok',
    ];

    $activeMenu = 'stok';

    return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }


    public function destroy($id)
    {
        $stok = StokModel::find($id);
        if ($stok) {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } else {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }
    }
}
