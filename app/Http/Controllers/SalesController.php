<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\SalesModel;
use illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Sales',
            'list' => ['Home', 'Sales']
        ];

        $page = (object) [
            'title' => 'Daftar sales barang dalam sistem'
        ];

        $activeMenu = 'sales';

        return view('sales.index', compact('breadcrumb', 'page', 'activeMenu'));
    }
    public function list(Request $request)
    {
        $sale = SalesModel::with(['user']);
        
        return DataTables::of($sale)
            ->addIndexColumn()
            ->addColumn('action', function ($sales) {
                $btn = '<a href="'.url('/sales/' . $sales->sales_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/sales/' . $sales->sales_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/sales/'.$sales->sales_id).'">'
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
            'title' => 'Tambah Sales',
            'list' => ['Home', 'Sales', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah sales baru',
        ];
        $users = UserModel::all();
        $activeMenu = 'sales';

        return view('sales.create', compact('breadcrumb', 'page','users', 'activeMenu'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli'=> 'required|string',
            'penjualan_tanggal'=> 'required|date',
            'penjualan_kode'=> 'required|integer',
        ]);

        SalesModel::create([
            'user_id' => $request->user_id,
            'pembeli'=> $request->pembeli,
            'penjualan_tanggal'=> $request->penjualan_tanggal,
            'penjualan_kode'=>$request->penjualan_kode,
        ]);

        return redirect('/sales')->with('success', 'Data sales berhasil disimpan');
    }

    public function edit($id)
    {
    $sales = SalesModel::find($id);
    $users = UserModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Sales',
        'list' => ['Home', 'Sales', 'Edit']
    ];

    $page = (object) [
        'title' => 'Edit sales',
    ];

    $activeMenu = 'sales';

    return view('sales.edit', compact('breadcrumb', 'page', 'stok', 'users', 'barangs', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'pembeli'=> 'required|string',
            'penjualan_tanggal'=> 'required|date',
            'penjualan_kode'=> 'required|integer',
        ]);

        SalesModel::find($id)->update([
            'user_id' => $request->user_id,
            'pembeli'=> $request->pembeli,
            'penjualan_tanggal'=> $request->penjualan_tanggal,
            'penjualan_kode'=>$request->penjualan_kode,
        ]);

        return redirect('/sales')->with('success', 'Data sales berhasil disimpan');

    return redirect('/stok')->with('success', 'Data stok berhasil diubah');
}
    public function show(string $id)
    {
    $stok = SalesModel::find($id);

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
        $stok = SalesModel::find($id);
        if ($stok) {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } else {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }
    }
}
