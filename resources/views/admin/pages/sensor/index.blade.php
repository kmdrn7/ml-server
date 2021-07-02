@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Management,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">

            <x-admin.index-button-control url="admin.sensor.add" title="sensor"/>

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
                                        <label for="os">OS</label>
                                        <select name="os" id="os" class="form-control select2">
                                            <option value="" selected disabled>All</option>
                                            <option value="Linux">Linux</option>
                                            <option value="Win">Win</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="arch">Arch</label>
                                        <select name="arch" id="arch" class="form-control select2">
                                            <option value="" selected disabled>All</option>
                                            <option value="AMD64">AMD64</option>
                                            <option value="ARMv7">ARMv7</option>
                                            <option value="ARMv8">ARMv8</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-style: dashed; margin-bottom: 20px; margin-top: 10px">
                            <table class="table table-responsive w-100 d-block d-md-table" id="mainDataTable">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Nama Sensor</th>
                                        <th>Serial</th>
                                        <th>OS</th>
                                        <th>Arch</th>
                                        <th>Status</th>
                                        <th width="100"><i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>nama sensor</td>
                                        <td>serial</td>
                                        <td>os</td>
                                        <td>arch</td>
                                        <td>status</td>
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

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewModalTitle">Detail Data</h4>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <tr>
                            <th width="120">ID</th>
                            <td id="v1"></td>
                        </tr>
                        <tr>
                            <th>Nama Sensor</th>
                            <td id="v2"></td>
                        </tr>
                        <tr>
                            <th>Serial</th>
                            <td id="v3"></td>
                        </tr>
                        <tr>
                            <th>OS</th>
                            <td id="v4"></td>
                        </tr>
                        <tr>
                            <th>Arch</th>
                            <td id="v5"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="v6"></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td id="vcreated"></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td id="vupdated"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp; Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        btnView = function(id){
            return '<div class="btn-group btn-group-sm"><a class="btn btn-warning" data-id="'+id+'" onclick="showData(\''+id+'\')">'
                    +'<i class="fa fa-eye text-white" aria-hidden="true"></i>';
                    +'</a>';
        };
        btnUpdate = function(id){
            return '<a href="{{ url()->current() }}/edit/'+id+'" class="update-button btn btn-info">'
                    +'<i class="fa fa-edit" aria-hidden="true"></i>';
                    +'</a>';
        }
        btnDelete = function(id){
            return '<a class="btn btn-danger" onclick="deleteButton(\''+id+'\')" data-id="'+id+'">'
                    +'<i class="fa fa-trash text-white" aria-hidden="true"></i>';
                    +'</a></div>';
        }

        ID_TABLE = 'id'
        SELECT_COLUMNS = []
        AjaxData = {
            os: () => {
                return $('#os').val();
            },
            arch: () => {
                return $('#arch').val();
            }
        }
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
                data: "serial"
            },
            {
                targets: [3],
                data: "os"
            },
            {
                targets: [4],
                data: "arch"
            },
            {
                targets: [5],
                data: "status",
                render: function(data){
                    return data == 1 ? "Active" : "Inactive";
                }
            },
            {
                targets: [6],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    id = full.id;
                    return btnView(id) + btnUpdate(id) + btnDelete(id);
                }
            }
        ];

        function showData(id) {
            $('#btnLoading').show();
            $('#failLoading').hide();
            console.log(id)
            $.ajax({
                type: "GET",
                url: "{{ url()->current().'/view' }}/"+id,
                dataType: "JSON",
                success: function ( res ) {
                    if ( res.status == 200 ) {
                        $('#btnLoading').hide();
                        $('#v1').html(res.data.res.id);
                        $('#v2').html(res.data.res.name);
                        $('#v3').html(res.data.res.serial);
                        $('#v4').html(res.data.res.os);
                        $('#v5').html(res.data.res.arch);
                        $('#v6').html(res.data.res.status == 1 ? 'Active':'Inactive');
                        $('#vcreated').html(res.data.res.created_at);
                        $('#vupdated').html(res.data.res.updated_at);
                        $('#viewModal').modal('show');
                    }
                },
                error: function(xhr, options, err){
                    $('#btnLoading').hide();
                    $('#failLoading').show();
                }
            });
        }

        let inc = 0;

        $(document).on('change', '#os', () => {
            if (inc!=0){
                DT.draw()
            }
        });

        $(document).on('change', '#arch', () => {
            if (inc!=0){
                DT.draw()
            }
        });

        inc++;
    </script>
@endsection