<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-body">
                @if ($url!="" && $title!="")
                    <a href="{{ route($url) }}" class="btn btn-success text-white"><i class="fas fa-plus fa-small"></i>&nbsp; Tambahkan {{ $title }}</a>
                @endif
                <button id="btnRefresh" class="btn btn-info text-white"><i class="fas fa-sync-alt fa-small"></i>&nbsp; Refresh</a>
                <button id="btnLoading" class="btn btn-primary is-loading is-loading-sm float-right" style="display: none">Button</button>
                <button id="failLoading" class="btn btn-danger float-right mr-2" style="display: none">Error saat melakukan fetch data...</button>
            </div>
        </div>
    </div>
</div>