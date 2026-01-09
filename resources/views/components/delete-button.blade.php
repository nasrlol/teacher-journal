@props(['route', 'confirmMessage' => 'Are you sure you want to delete this item?'])

<form action="{{ $route }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $confirmMessage }}')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger" {{ $attributes }}>
        <i class="bi bi-trash"></i>
        {{ $slot->isEmpty() ? 'Delete' : $slot }}
    </button>
</form>

