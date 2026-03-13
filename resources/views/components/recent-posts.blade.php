@foreach($recent_posts as $post)
  <h3><a href="{!! get_the_permalink($post->ID) !!}">{!! get_the_title($post->ID) !!}</a></h3>
@endforeach
