@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Management,{{ $title }},sensor [{{ $serial }}]"/>

        <div class="container-fluid page__container">

            <div class="row mt-0">
                <div class="col-lg">
                    <div class="card">
                        <div class="card-header card-header-large bg-white">
                            <h4 class="mb-0">Report</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive w-100 d-block d-md-table" id="mainDataTable">
                                <thead>
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Timestamp</th>
                                        <th>Src IP</th>
                                        <th>Src Port</th>
                                        <th>Dst IP</th>
                                        <th>Dst Port</th>
                                        <th>Protocol</th>
                                        <th>Prediction</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
        ID_TABLE = 'id'
        SELECT_COLUMNS = []
        AjaxData = {
            serial: "{{ $serial }}"
        }
        PAGE_LENGTH = 25
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
                data: "timestamp",
                render: function(data){
                    return data.split(".")[0]
                }
            },
            {
                targets: [2],
                data: "src_ip"
            },
            {
                targets: [3],
                data: "src_port"
            },
            {
                targets: [4],
                data: "dst_ip"
            },
            {
                targets: [5],
                data: "dst_port",
            },
            {
                targets: [6],
                data: "protocol",
                render: function ( data ) {
                    let proto = 'Unknown';
                    switch (data) {
                        case 1:
                            proto = "ICMP";
                            break;
                        case 2:
                            proto = "IGMP";
                            break;
                        case 4:
                            proto = "IP";
                            break;
                        case 6:
                            proto = "TCP";
                        case 17:
                            proto = "UDP";
                            break;
                            break;
                        default:
                            break;
                    }
                    return proto;
                }
            },
            {
                targets: [7],
                data: "prediction",
                render: function(data){
                    return data == 1 ? "Malicious" : "Benign"
                }
            }
        ];
    </script>
@endsection