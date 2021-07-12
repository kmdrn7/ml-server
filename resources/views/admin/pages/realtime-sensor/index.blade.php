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
                                        <label for="sensor">Sensor</label>
                                        <select class="form-control select2" id="sensor">
                                            @foreach ($sensor as $data)
                                                <option value="{{ $data->serial }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="display">Display</label>
                                        <select class="form-control select2" id="display">
                                            <option value="table">Table</option>
                                            <option value="doughnut-chart">Doughnut Chart</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button class="btn btn-info" id="start-stream" style="margin-top: 27px">
                                            <i class="fa fa-play" id="stream-icon"></i>&nbsp;
                                            Stream
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-style: dashed; margin-bottom: 15px; margin-top: 10px">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="margin-bottom: 5px">Sensor Name : [ <b><span id="sensor_name"></span></b> ]</p>
                                    <p style="margin-bottom: 5px">Sensor OS : [ <b><span id="sensor_os"></span></b> ]</p>
                                    <p style="margin-bottom: 5px">Sensor Arch : [ <b><span id="sensor_arch"></span></b> ]</p>
                                    <p style="margin-bottom: 5px">Sensor Serial : [ <b><span id="sensor_serial"></span></b> ]</p>
                                    <p style="margin-bottom: 5px">Sensor Status : [ <b><span id="sensor_status"></span></b> ]</p>
                                </div>
                                <div class="col-md-6">
                                    <p id="spin-info" style="display: none">
                                        <i class="fa fa-asterisk fa-spin" style="margin-right: 5px"></i>
                                        Streaming data...
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <div id="wrapper-data" style="height: 400px; overflow-y: scroll; margin-top: 15px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Src IP</th>
                                                    <th>Src Port</th>
                                                    <th>Dest IP</th>
                                                    <th>Dest Port</th>
                                                    <th>Protocol</th>
                                                    <th>Timestamp</th>
                                                    <th>Prediction</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-body-data">
                                                <tr class="first-data">
                                                    <td colspan="7" class="text-center">press stream button to start streaming the data</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- <div class="chart">
                                        <canvas id="devicesChart" class="chart-canvas"></canvas>
                                    </div> --}}
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
        let socket;
        $(document).on('click', '#start-stream', () => {
            const sensor_serial = $('#sensor').val();
            $.ajax({
                type: "GET",
                url: "{{ url()->current().'/view' }}/"+sensor_serial,
                dataType: "JSON",
                success: function ( res ) {
                    if ( res.status == 200 ) {
                        $('#sensor_name').html(res.data.name);
                        $('#sensor_serial').html(res.data.serial);
                        $('#sensor_status').html(res.data.status == 1 ? "Active":"Inactive");
                        $('#sensor_os').html(res.data.os);
                        $('#sensor_arch').html(res.data.arch);
                        $('.first-data').remove();

                        try {
                            socket.disconnect();
                        } catch (error) { }

                        socket = io("http://0.0.0.0:4444/sensor", {
                            query:{
                                sensor_serial,
                            },
                        });

                        socket.on("data", (data) => {
                            $('#table-body-data').prepend('<tr><td>'+data.src_ip+'</td><td>'+data.src_port+'</td><td>'+data.dst_ip+'</td><td>'+data.dst_port+'</td><td>'+data.protocol+'</td><td>'+data.timestamp+'</td><td>'+(data.prediction == 0 ? "Benign":"Malware")+'</td></tr>');
                        })

                        $('#spin-info').css('display', 'block')
                    }
                },
            });
        });



        // $.ajax({
        //     type: "GET",
        //     url: "{{ url()->current().'/view' }}/"+id,
        //     dataType: "JSON",
        //     success: function ( res ) {
        //         if ( res.status == 200 ) {
        //             $('#btnLoading').hide();
        //             $('#v1').html(res.data.res.id);
        //             $('#v2').html(res.data.res.name);
        //             $('#v3').html(res.data.res.serial);
        //             $('#v4').html(res.data.res.os);
        //             $('#v5').html(res.data.res.arch);
        //             $('#v6').html(res.data.res.status == 1 ? 'Active':'Inactive');
        //             $('#v7').html(res.data.res.dockerfile);
        //             $('#v8').html(res.data.res.last_healthcheck);
        //             $('#vcreated').html(res.data.res.created_at);
        //             $('#vupdated').html(res.data.res.updated_at);
        //             $('#viewModal').modal('show');
        //         }
        //     },
        //     error: function(xhr, options, err){
        //         $('#btnLoading').hide();
        //         $('#failLoading').show();
        //     }
        // });
    </script>
@endsection