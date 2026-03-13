<div class="container-fluid standard-header position-relative">
  <div class="container h-100">
    <div class="row align-content-center align-items-center h-100">
      <h1 class="text-white sage-mt-120 col-24 col-lg-12 offset-lg-1 col-xl-10 offset-xl-2">{!! $standard_title !!}</h1>
    </div>
  </div>

  @if($is_archive)
    <x-acf-image :image-id="$image_id" size="full" srcset-sizes="100vw" class="featured-image sage-banner-image" style="{{ $featured_image_positioning ? 'object-position: ' . $featured_image_positioning . ';' : '' }}"/>
  @else
    <x-featured-image :image-id="$post_id" size="full" srcset-sizes="100vw" class="featured-image sage-banner-image" style="{{ $featured_image_positioning ? 'object-position: ' . $featured_image_positioning . ';' : '' }}"/>
  @endif

</div>
