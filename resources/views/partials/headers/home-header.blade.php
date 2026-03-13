<div class="container-fluid sage-px-0 sage-pt-md-150 homepage-header position-relative">

  <div class="container position-relative h-100">

    <div class="row h-100 align-content-center">

      <div class="content-wrapper col-24 sage-px-30 sage-px-md-0 col-md-12 offset-md-1 col-xl-10 offset-xl-2">

        @if($home_title)
          <h1 class="text-white">{!! $home_title !!}</h1>
        @endif

        @if($copy)
          <p class="text-white">{!! $copy !!}</p>
        @endif

      </div>

    </div>

  </div>

  <x-featured-image :image-id="$post_id" size="full" srcset-sizes="100vw" class="featured-image sage-banner-image" style="{{ $featured_image_positioning ? 'object-position: ' . $featured_image_positioning . ';' : '' }}"/>

</div>
