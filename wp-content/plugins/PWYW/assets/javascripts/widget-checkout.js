jQuery(document).ready(function($) {

    // Amount buttons
    // -------------------------------------------------------------------------
    $('.customshow').hide();
    $('.pwyw-amount button').click(function() {
        if ($(this).attr('id') == 'custom_price') {
            $('.customshow').fadeIn('fast');
        } else {
            $('.customshow').fadeOut('fast');
        }
    });

    // Sliders
    // -------------------------------------------------------------------------
    var min=0;
    var max=100;

    function setSliderHandlers(slider_class,input_class)
    {
        var default_val = 0;
        $('.'+input_class).val(0);

        $( "."+slider_class ).slider(
        { animate: true },
        { min: min },
        { max: max },
        {change: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));
            }},
        {slide: function(event, ui) {
                var id = $(this).attr('id').match(/slider_(.+)/)[1];
                $('#'+id+'_inp').val($(this).slider('value'));
            }});

        $('.'+input_class).each(function(){
            var id = $(this).attr('id').match(/(.+)_inp/)[1];
            var slider = $('#slider_'+id);

            if(slider.attr('value') != ''){
                $(this).val(slider.attr('value'));
                slider.slider("value",slider.attr('value'));
            }else{
                $(this).val(default_val);
            }

            $(this).change(function(){
                slider.slider("value" , $(this).val());
            })
        })

        $('div.'+slider_class).linkedSliders({
            total: 100,  // The total for all the linked sliders
            policy: 'next' // Adjustment policy: 'next', 'prev', 'first', 'last', 'all'
        });

    }

    setSliderHandlers('linked3', 'percent');
    setSliderHandlers('sub_charities','charities_percent');
    setSliderHandlers('sub_filmmakers','filmmakers_percent');

    // Handle the dive deeper buttons
    $('.dive-deeper').click(function() {
        var id = $(this).data('id');
        $(id).toggle('slow');
    });
    $('.dive-deeper').tooltip({
        placement: 'top',
        html: true
    });
});
