<div class="container-fluid bio-grid">
  <div class="container">
    <div class="row sage-g-0 col-24 offset-xl-1 col-xl-22 sage-pt-30 sage-pb-40">
      <div class="col-24">
        @if ($module->title)
          <h2 class="text-center">{!! $module->title !!}</h2>
        @endif
        <div class="row sage-g-md-15 sage-g-lg-20 sage-g-xl-25">
          @foreach ($module->bios as $bio)
          <div class="card-wrapper col-24 col-sm-12 col-md-8 sage-mb-50 sage-mb-md-100">
            <x-bio-card modal="bios_modal" :bio-id="$bio" class="col-24 col-sm-12 col-md-8"/>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade bios-modal" id="bios_modal" tabindex="-1" aria-labelledby="bio_wrapper" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-inner container-fluid bg-color-bp-alpha sage-pt-170 sage-pb-130">
      <div class="container">
        <div class="row">
            <div class="image-wrapper col-24 sage-mb-40 sage-mb-md-0 d-flex justify-content-center d-md-block offset-md-1 col-md-9 offset-lg-2 col-lg-8 offset-xl-3 col-xl-7">
                <div class="ratio" style="--bs-aspect-ratio: 110.73%">
                  <div id="bio_image" class="sage-bg-image"></div>
                  <img class="visually-hidden" id="bio_alt_image"/>
                </div>
            </div>
            <div class="content-wrapper col-24 col-md-11 col-lg-10 col-xl-9 offset-md-1">
                <div class="name-wrapper sage-pb-30">
                    <h2 id="bio_name" class="white-color sage-mb-20"></h2>
                    <p id="bio_title" class="sage-mb-10 bp-bravo-color"></p>
                    <p id="bio_company" class="sage-mb-0 bp-bravo-color"></p>
                </div>
                <div class="info-wrapper sage-pt-30" id="info_wrapper" class="sage-pt-30">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
  </div>
</div>
