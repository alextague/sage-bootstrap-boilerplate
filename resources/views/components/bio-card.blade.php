<div class="card card-bio">
  <div class="ratio sage-mb-30" style="--bs-aspect-ratio: 110.73%">
    <x-featured-image :image-id="$bio_id" class="card-img-top sage-cover-image"/>
  </div>
  <a class="stretched-link position-static sage-mb-10 text-decoration-none bp-bravo-color modal-launch" href="#" data-bs-target="#{!! $modal !!}" data-bs-toggle="modal" data-first-name="{!! $first_name !!}" data-last-name="{!! $last_name !!}" data-image="{{ $featured_image }}" data-title="{{ $bio_title }}" data-company="{{ $bio_company }}" data-info="{{ $info }}"><h3 class="fw-bold sage-mb-0 sage-font-primary text-capitalize sage-font-lg"> {!! $first_name !!} {!! $last_name !!}</h3></a>
  <div class="separator bg-color-bp-delta sage-mb-15">
  </div>
  <p class="sage-mb-5 bio-title">{!! $bio_title !!}</p>
  <p class="sage-mb-0 bio-company">{!! $bio_company !!}</p>
</div>
