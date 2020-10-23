@if (count($category->children) > 0)
<li>
    <span class="caret"></span>
    <a href="{{ route('category.show', $category->id) }}">
        {{ $category->title }}
    </a>
    <ul class="sidebar-menu nested">
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