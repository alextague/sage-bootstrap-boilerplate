(function($){ // eslint-disable-line no-unused-vars

  $(".modal-launch").on("click", function() {
    let first_name = $(this).data('first-name');
    let last_name = $(this).data('last-name');
    let image = $(this).data('image');
    let title = $(this).data('title');
    let company = $(this).data('company');
    let info = $(this).data('info');

    $('#bio_name').html(first_name + ' ' + last_name);
    $('#bio_image').css('background-image', 'url(' + image + ')');
    $('#bio_title').html(title);
    $('#bio_alt_image').attr('alt', first_name + ' ' + last_name);
    $('#bio_company').html(company);
    $('#info_wrapper').html(JSON.parse(info));
  })

})(jQuery)
