@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Management,{{ $title }},{{ $state }}"/>

        <div class="container-fluid page__container">

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
                                        <th>Sensor [serial] [platform]</th>
                                        <th>Model</th>
                                        <th width="100"><i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>sensor</td>
                                        <td>model</td>
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
                data: "name",
                render: function(data, type, full){
                    return `${full.name} [${full.serial}] [${full.os}/${full.arch}]`;
                }
            },
            {
                targets: [2],
                data: "model",
                render: function(data){
                    return data ? data.name : "-";
                }
            },
            {
                targets: [3],
                class: 'text-center',
                sortable: false,
                searchable: false,
                render: function ( data, type, full, meta ) {
                    id = full.id;
                    return btnView(id) + btnUpdate(id) + btnDelete(id);
                }
            }
        ];

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