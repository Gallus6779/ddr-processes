<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white p-2 mb-3 border">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard.index') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        {{ $slot }}
    </ol>
</nav>
