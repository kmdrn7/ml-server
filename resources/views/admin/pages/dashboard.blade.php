@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mdk-drawer-layout__content page pb-0">
        <div class="container-fluid page__heading-container">
            <div class="page__heading d-flex align-items-center pb-3">
                <div class="flex">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <h1 class="mt-2">Dashboard</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid page__container">
            <div class="row card-group-row">
                <div class="col-lg-4 col-md-6 card-group-row__col">
                    <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                        <div class="flex">
                            <div class="card-header__title text-muted mb-2">Jumlah Sensor</div>
                            <div class="text-amount" id="">{{ $count['sensor'] }} <span style="letter-spacing: 0">sensor</span></div>
                        </div>
                        <div><i class="material-icons icon-muted icon-40pt ml-3">device_hub</i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 card-group-row__col">
                    <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                        <div class="flex">
                            <div class="card-header__title text-muted mb-2">Jumlah Model</div>
                            <div class="text-amount" id="">{{ $count['model'] }} <span style="letter-spacing: 0">model</span></div>
                        </div>
                        <div><i class="material-icons icon-muted icon-40pt ml-3">dns</i></div>
                    </div>
                </div>
            </div>

            {{-- <div class="row card-group-row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-large bg-white d-flex align-items-center">
                            <h4 class="card-header__title flex m-0">Statistik Penggunaan Disk</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="disk-info" width="100%" height="75"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('modal')
    <div id="loading-dashboard" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-center-title" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-center-title">Loading Data</h5>
                </div> <!-- // END .modal-header -->
                <div class="modal-body">
                    <p class="mb-0">Sedang memuat data statistis web</p>
                </div> <!-- // END .modal-body -->
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div>
@endsection

@section('js')
    <script>
        let stat, bagi
        let ctxDisk = document.getElementById('disk-info').getContext('2d');
        let chartDisk = new Chart(ctxDisk, {
            type: 'pie',
            data: {
                datasets: [ ],
                labels: [ ],
            }
        });

        $(function(){
            getDiskInfo()
        })

        function getDiskInfo(){
            $.ajax({
                type: "GET",
                url: "{{ admin('util/disk-info') }}",
                dataType: "JSON",
                success: function (res) {
                    console.log(res)
                    chartDisk.data.labels.push("Dipakai ("+ res.dipakai +" MB)")
                    chartDisk.data.labels.push("Tersisa ("+ res.sisa +" MB)")
                    chartDisk.data.datasets.push({
                        data: [res.raw.dipakai, res.raw.sisa],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(86, 165, 255, 0.5)'
                        ]
                    })
                    chartDisk.update()
                }
            });
        }
    </script>
@endsection