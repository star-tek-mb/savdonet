@if (isset($category))
@if ($category->parent)
@include('layouts.breadcrumb-category', ['category' => $category->parent])
@endif
@if (Route::currentRouteName() == 'category.show' && Request::route('id')==$category->id)
<li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
@else
<li class="breadcrumb-item"><a href="{{ route('category.show', $category->id) }}">{{ $category->title }}</a></li>
@endif
@endif