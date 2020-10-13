<div class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($product->variations as $variation)
        <div class="carousel-item @if($loop->first) active @endif">
            <img src="{{ Storage::url($variation->photo_url) }}" class="d-block w-100">
        </div>
        @endforeach
    </div>
</div>