        @if(isset($parents))
            <ol class="breadcrumb">
                <li><a href="/categories">Categories</a></li>
            @foreach($parents as $cat)
                <li><a href="/categories/{{ $cat['id'] }}">{{ $cat['category'] }}</a></li>
            @endforeach
                <li><a href="/categories/{{ $category->id }}">{{ $category->category }}</a></li>
            </ol>
        @endif