<div class="container-fluid contact-info sage-my-md-90 sage-my-45">
  <div class="container">
    <div class="row">
      <div class="offset-md-1 offset-xl-2 col-md-7 col-lg-6 col-xl-5 contact-info-column order-md-1 order-2">
        <h3 class="sage-mb-10">{!! $module->business_name !!}</h3>
        <a href="{{ $module->website['url'] }}" class="bp-bravo-color text-decoration-none fw-bold sage-font-md" target="{!! $module->website['target'] !!}">{!! $module->website['title'] !!}@if($module->website['target']) <img src="@asset('images/external-link.svg')" class="sage-ml-5 align-baseline" alt="External Link">@endif</a>
        <p class="sage-mt-30 sage-mb-0 fw-bold">Email</p>
        <p class="sage-mb-30">{!! $module->email !!}</p>
        <p class="sage-mt-30 sage-mb-0 fw-bold">Phone Number</p>
        <p class="sage-mb-30">{!! $module->phone_number !!}</p>
        <a href="{{ $module->google_link['url'] }}" class="bp-bravo-color text-decoration-none fw-bold sage-font-md" target="{!! $module->google_link['target'] !!}">{!! $module->google_link['title'] !!}@if($module->google_link['target']) <img src="@asset('images/external-link.svg')" class="sage-ml-5 align-baseline" alt="External Link">@endif</a>
      </div>
      <div class="offset-md-1 offset-xl-2 col-md-14 col-lg-15 col-xl-13 order-md-2 order-1">
        <h2>{!! $module->title !!}</h2>
        {!! $module->copy !!}
      </div>
    </div>
  </div>
</div>
