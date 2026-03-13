<header class="sage-header sage-px-15">
  <div class="inner sage-py-15 sage-px-15 sage-px-md-30 sage-px-lg-60 sage-px-xl-75">
    <div class="row justify-content-between align-items-center">
      <x-header-logo/>
      <div class="menu-wrapper col-auto d-none d-md-block">
        <x-nav-menu menu-location="primary_navigation"/>
      </div>
      <div class="hamburger-wrapper d-flex align-items-center d-md-none col-auto">
        <button class="hamburger hamburger--slider d-flex" id="mobile_menu_show_toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile_menu" aria-controls="mobile_menu">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>
    </div>
  </div>
</header>
<div class="offcanvas offcanvas-top" id="mobile_menu">
  <div class="menu-header sage-px-15 sage-py-30 d-flex justify-content-between align-items-center">
    <div class="logo-wrapper">
    </div>
    <div class="hamburger-wrapper d-flex col-auto">
      <button class="hamburger is-active hamburger--slider d-flex" id="mobile_menu_close_toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile_menu" aria-controls="mobile_menu">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
    </div>
  </div>
  <div class="mobile-menu-wrapper" id="mobile_menu">
    <x-mobile-nav menu-location="primary_navigation"/>
  </div>
</div>
