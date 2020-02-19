@if(count($posts))
    <ul>
        @foreach($posts as $post)
            <li class="my-2">
                <strong><a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a></strong>

                @include('post._meta')
            </li>
        @endforeach
    </ul>
@else
    <div class="alert alert-info">{{ __('No post created yet') }}</div>
@endif