@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Manajemen,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">

            <x-admin.index-button-control url="" title="ip"/>

            <div class="row mt-0">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header card-header-large bg-white">
                            <h4 class="mb-0">{{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Klinik</label>
                                        <select class="form-control select2" id="klinik">
                                            <option value="">Semua</option>
                                            @foreach ($pharmacy as $data)
                                                <option value="{{ $data->serial }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select class="form-control select2" id="status">
                                            <option value="">Semua</option>
                                            <option value="1">Approved</option>
                                            <option value="0">Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-responsive w-100 d-block d-md-table" id="mainDataTable">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Nama</th>
                                        <th>IPv4</th>
                                        <th>IPv6</th>
                                        <th>Status</th>
                                        <th width="100"><i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>name</td>
                                        <td>ipv4</td>
                                        <td>ipv6</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footer')
    </div>
@endsection

@section('js')
    <script>
        btnView = function(id){
            return '<div class="btn-group btn-group-sm">';
        };
        btnUpdate = function(id){
            return '<a href="{{ url()->current() }}/edit/'+id+'" class="update-button btn btn-info">'
                    +'<i class="fa fa-edit" aria-hidden="true"></i>';
                    +'</a>';
        }
        btnDelete = function(id){
            return '</div>';
        }

        AjaxData = {
            klinik: () => {
                return $('#klinik').val();
            },
            status: () => {
                return $('#status').val();
            }
        }
        ID_TABLE = 'serial'
        SELECT_COLUMNS = []
        COLUMNS = [
            {
                targets: [0],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                targets: [1],
                data: "name"
            },
            {
                targets: [2],
                data: "IPv4"
            },
            {
                targets: [3],
                data: "IPV6"
            },
            {
                targets: [4],
                data: "status",
                render: function(data){
                    return data == true ? '<span class="btn btn-sm btn-success">Approved<span>' : '<span class="btn btn-sm btn-warning text-black">Pending<span>';
                }
            },
            {
                targets: [5],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    id = full.serial;
                    return btnView(id) + btnUpdate(id) + btnDelete(id);
                }
            }
        ];

        function showData(id) {}

        let inc = 0;

        $(document).on('change', '#klinik', () => {
            if (inc!=0){
                DT.draw()
            }
        });

        $(document).on('change', '#status', () => {
            if (inc!=0){
                DT.draw()
            }
        });

        inc++;
    </script>
@endsection