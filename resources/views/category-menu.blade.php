@if (count($category->children) > 0)
<li>
    <a href="{{ route('category.show', $category->id) }}">
        {{ $category->title }}
    </a>
    <ul class="sidebar-menu">
        @each('category-menu', $category->children, 'category')
    </ul>
</li>
@else
<li>
    <a href="{{ route('category.show', $category->id) }}">
        {{ $category->title }}
    </a>
</li>
@endif