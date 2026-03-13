@if ($header_type == 'homepage')
  @include ('partials.headers.home-header')
@elseif ($header_type == 'standard')
  @include ('partials.headers.standard-header')
@elseif ($header_type == 'background_image')
  @include ('partials.headers.background-image-header')
@endif
