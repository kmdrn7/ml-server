@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Utilitas,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">

            <x-admin.index-button-control url="admin.config.add"/>

            <div class="row mt-0">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header card-header-large bg-white">
                            <h4 class="mb-0">{{ $title }}</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive w-100 d-block d-md-table" id="mainDataTable">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th width="100"><i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>key</td>
                                        <td>value</td>
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
                            <th>Key</th>
                            <td id="v2"></td>
                        </tr>
                        <tr>
                            <th>Value</th>
                            <td id="v3"></td>
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
            return '</div>';
        }

        ID_TABLE = 'id_config'
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
                data: "key"
            },
            {
                targets: [2],
                data: "value"
            },
            {
                targets: [3],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    id = full.guid_config;
                    return btnView(id) + btnUpdate(id) + btnDelete(id);
                }
            }
        ];

        function showData(id) {
            $('#btnLoading').show();
            $('#failLoading').hide();
            $.ajax({
                type: "GET",
                url: "{{ url()->current().'/view' }}/"+id,
                dataType: "JSON",
                success: function ( res ) {
                    if ( res.status == 200 ) {
                        $('#btnLoading').hide();
                        $('#v1').html(res.data.guid_config);
                        $('#v2').html(res.data.key);
                        $('#v3').html(res.data.value);
                        $('#vcreated').html(res.data.created_at);
                        $('#vupdated').html(res.data.updated_at);
                        $('#viewModal').modal('show');
                    }
                },
                error: function(xhr, options, err){
                    $('#btnLoading').hide();
                    $('#failLoading').show();
                }
            });
        }
    </script>
@endsection