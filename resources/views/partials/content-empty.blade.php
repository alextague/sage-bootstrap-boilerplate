<div class="container-fluid sage-py-60">
  <div class="container">
    <div class="row align-items-center justify-content-center text-center flex-column">

        <div class="empty-warning">

          @if( current_user_can('editor') || current_user_can('administrator') )

            <h2 class="error">Oh my! This page needs some content.</h2>
            @php edit_post_link('Add Content', '<p>', '</p>', '', 'btn btn-lg btn-danger'); @endphp

          @else

        	  <h2 class="error">Oops! Something went wrong.</h2> <p>Please check back later. (If you have a moment, <a href="mailto:{{get_option( 'admin_email' )}}?subject=Issue with {{get_option( 'siteurl' )}}&body=The {{get_the_title()}} page is missing content or broken. Just letting you know!">let us know it's broken</a>.)</p>

          @endif

        </div>

    </div>
  </div>
</div>
