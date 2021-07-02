<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center pb-3">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Admin</a></li>
                    @foreach (explode(',', $items) as $item)
                        <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
                    @endforeach
                </ol>
            </nav>
            <h1 class="mt-2">{{ $title }}</h1>
            <small>{{ $subtitle }}</small>
        </div>
    </div>
</div>