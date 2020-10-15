<a href="{{ route('product.show', $product->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
<a href="{{ route('backend.products.edit', $product->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
<form class="d-none" action="{{ route('backend.products.destroy', $product->id) }}" method="POST">
    @method('DELETE')
    @csrf
</form>
@if (!isset($delete))
<a onclick="event.preventDefault(); if (confirm('{{ __('Are you sure?') }}')) { $(this).prev().submit(); }" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
@endif