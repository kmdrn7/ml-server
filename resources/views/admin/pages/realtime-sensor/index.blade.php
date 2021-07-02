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
                                        <label for="sensor">Display</label>
                                        <select class="form-control select2" id="sensor">
                                            <option value="table">Table</option>
                                            <option value="doughnut-chart">Doughnut Chart</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-style: dashed; margin-bottom: 15px; margin-top: 10px">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Sensor Name : [ Sensor Name ]</h6>
                                    <h6>Sensor Serial : [ 312987324 ]</h6>
                                    <h6>Sensor Status : [ Active ]</h6>
                                    <div id="wrapper-data" style="height: 400px; overflow-y: scroll; margin-top: 15px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Flow</th>
                                                    <th>Timestamp</th>
                                                    <th>Prediction</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="3" class="text-center">Menunggu data ...</td>
                                                </tr>
                                                <tr>
                                                    <td>1290839084792384234</td>
                                                    <td>1290380912830123</td>
                                                    <td>Malware</td>
                                                </tr>
                                                <tr>
                                                    <td>1290839084792384234</td>
                                                    <td>1290380912830123</td>
                                                    <td>Malware</td>
                                                </tr>
                                                <tr>
                                                    <td>1290839084792384234</td>
                                                    <td>1290380912830123</td>
                                                    <td>Benign</td>
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
        // Setting socket
        const socket = io("http://0.0.0.0:4444/sensor");
        socket.emit("msg", "hello")
    </script>
@endsection