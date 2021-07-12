@extends('admin.layouts.app')

@section('title', $title)

@section('content')
    <!-- MK Drawer Layout -->
    <div class="mdk-drawer-layout__content page pb-0">

        <x-admin.breadcrumb :title="$title" :subtitle="$subtitle" items="Management,{{ $title }}"/>

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
                                            <option value="all" selected>All</option>
                                            <option value="Linux">Linux</option>
                                            <option value="Win">Win</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="arch">Arch</label>
                                        <select name="arch" id="arch" class="form-control select2">
                                            <option value="all" selected>All</option>
                                            <option value="AMD64">AMD64</option>
                                            <option value="ARMv7">ARMv7</option>
                                            <option value="ARMv8">ARMv8</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time">Time</label>
                                        <div id="time-now"></div>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-style: dashed; margin-bottom: 10px; margin-top: 10px">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="wrapper-data" style="margin-top: 15px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sensor [serial] [platform]</th>
                                                    <th>Status</th>
                                                    <th>Last Health Check</th>
                                                </tr>
                                            </thead>
                                            <tbody id="monitor-tbody">
                                                <tr style="text-align: center">
                                                    <th colspan="3">Waiting the data...</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footer')
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.2/socket.io.js" integrity="sha512-YybopSVjZU0fe8TY4YDuQbP5bhwpGBE/T6eBUEZ0usM72IWBfWrgVI13qfX4V2A/W7Hdqnm7PIOYOwP9YHnICw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let os = $('#os').val();
        let arch = $('#arch').val();

        $(document).on('change', '#os', () => {
            os = $('#os').val()
            pollingLoadData(os, arch)
        });

        $(document).on('change', '#arch', () => {
            arch = $('#arch').val()
            pollingLoadData(os, arch)
        });

        $('#time-now').html(new Date())

        setInterval(() => {
            pollingLoadData(os, arch)
            $('#time-now').html(new Date())
        }, 5000);

        function pollingLoadData(os, arch) {
            $.ajax({
                type: "GET",
                url: "{{ url()->current().'/data' }}/"+os+"/"+arch,
                dataType: "JSON",
                success: function ( res ) {
                    if ( res.status == 200 ) {
                        $('#monitor-tbody').html('')
                        let tr = ''
                        res.data.map((el) => {
                            tr += '<tr>';
                                tr += '<td>';
                                tr += `<b>${el.name}</b> [${el.serial}] [${el.os}/${el.arch}]`;
                                tr += '</td>';
                                tr += '<td>';
                                tr += el.status == 1 ?"Active":"Inactive";
                                tr += '</td>';
                                tr += '<td>';
                                tr += el.last_healthcheck ? el.last_healthcheck : "Not Activated";
                                tr += '</td>';
                            tr += '</tr>'
                        })
                        $('#monitor-tbody').html(tr)
                    }
                },
            });
        }
    </script>
@endsection