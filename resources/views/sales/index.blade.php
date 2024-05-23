@extends('layout.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('sales/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_sales">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID User </th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataTable = $('#table_sales').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('sales/list') }}",
                    dataType: "json",
                    type: "POST",
                },
                columns: [
                    { data: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                    { data: 'user_id', className: '', orderable: true, searchable: true },
                    { data: 'pembeli', className: '', orderable: true, searchable: true },
                    { data: 'penjualan_tanggal', className: '', orderable: true, searchable: true },
                    { data: 'penjualan_kode', className: '', orderable: true, searchable: true },
                    { data: 'action', className: '', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
