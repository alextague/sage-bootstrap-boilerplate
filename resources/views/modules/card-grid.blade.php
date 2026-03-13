<div class="container-fluid card-grid sage-py-md-100 sage-py-50 {{ $module->background_color ? 'bg-color-bp-echo' : '' }}">
  <div class="container">
    <div class="row text-center">
        <h2 class="offset-md-6 col-md-12 sage-mb-20">{!! $module->title !!}</h2>
        <p class="offset-md-2 col-md-20 sage-mb-90">{!! $module->copy !!}</p>
        <div class="offset-md-2 col-md-20 cards-wrapper">
          <div class="row">
            @foreach($module->cards as $card)
            <div class="col-12 col-sm-8 col-lg-6 sage-mb-15">
              <div class="position-relative border-0 card">
                <div class="ratio ratio-1x1">
                  <x-acf-image :image-id="$card['background_image']" class="card-img rounded-0"/>
                  <div class="card-img-overlay d-flex align-items-center justify-content-center sage-p-0">
                    <a href="{{ $card['link']['url'] }}" class="white-color text-decoration-none text-uppercase sage-font-xl stretched-link sage-font-secondary">{!! $card['link']['title'] !!}</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
  </div>
</div>
