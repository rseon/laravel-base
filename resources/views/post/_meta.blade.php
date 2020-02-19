<small class="text-muted">
    <br>
    {{ __('post.meta_by') }} <a href="{{ route('author', $post->author) }}">{{ $post->author->name }}</a>
    @if(count($post->categories))
        {{ __('post.meta_in') }}
        {!!
            $post->categories->map(function($c) {
                return '<a href="'.route('category', $c).'">'.$c->name.'</a>';
            })->implode(', ')
        !!}
    @endif
    - {{ date_i18n($post->created_at) }}
</small>