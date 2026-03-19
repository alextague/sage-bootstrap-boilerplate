@if ($header_type == 'homepage')
  @include ('partials.headers.home-header')
@elseif ($header_type == 'standard')
  @include ('partials.headers.standard-header')
@endif
