<div class="container-fluid sage-px-0 header-single background-image-header position-relative sage-bg-image">

  <div class="container">

    <div class="row h-100 sage-pb-60">

      <div class="content-wrapper align-content-end text-center text-white col-24">

        <h1 class="sage-h2 text-center text-uppercase">{!! $title !!}</h1>

        <div class="share-wrapper d-flex align-items-center">
          <x-yoast-social-sharing :post-id="$post_id" share-text="Share This Post: " :share-to-array="['facebook', 'pinterest', 'twitter']"/>
        </div>

      </div>

    </div>

  </div>

  <x-featured-image :image-id="$post_id" size="full" srcset-sizes="100vw" class="featured-image sage-banner-image" style="{{ $featured_image_positioning ? 'object-position: ' . $featured_image_positioning . ';' : '' }}"/>

</div>
