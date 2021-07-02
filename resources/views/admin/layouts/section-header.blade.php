<div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ admin('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ admin($idh) }}">{{ $title }}</a></div>
        <div class="breadcrumb-item">{{ $page }}</div>
    </div>
</div>