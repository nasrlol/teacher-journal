@props(['title', 'count' => null, 'icon' => 'bi-card-text', 'color' => 'primary'])

<div class="card h-100">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-{{ $color }} bg-opacity-10 p-3 me-3">
                <i class="bi {{ $icon }} fs-4 text-{{ $color }}"></i>
            </div>
            <div>
                @if($count !== null)
                    <h3 class="mb-0">{{ $count }}</h3>
                @endif
                <p class="text-muted mb-0">{{ $title }}</p>
            </div>
        </div>
    </div>
    @if($slot->isNotEmpty())
        <div class="card-footer bg-transparent border-0">
            {{ $slot }}
        </div>
    @endif
</div>

