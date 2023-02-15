/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */
/* ------------------------------------------------------------------------------
 *
 *  # Bootstrap multiselect
 *
 *  Demo JS code for form_multiselect.html page
 *
 * ---------------------------------------------------------------------------- */


/* ------------------------------------------------------------------------------
 *
 *  # Bootstrap multiselect
 *
 *  Demo JS code for form_multiselect.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var BootstrapMultiselect = function() {


    //
    // Setup module components
    //

    // Default file input style
    var _componentMultiselect = function() {
        if (!$().multiselect) {
            console.warn('Warning - bootstrap-multiselect.js is not loaded.');
            return;
        }


        // Basic examples
        // ------------------------------

        // Basic initialization
        //$('.multiselect').multiselect();


        // Events
        // ------------------------------

        // onChange
        $('.multiselect').multiselect({
            onChange: function(element, checked){
                var brands = $('.multiselect option:selected');
                var selected = [];
                $(brands).each(function(index, brand){
                    selected.push([$(this).val()]);
                });

                $('#categories').val(selected);
            }
        });

        // onShow
        $('.multiselect-show-event').multiselect({
            onDropdownShow: function() {
                alert('onDropdownShow event fired');
            }
        });

        // onHide
        $('.multiselect-hide-event').multiselect({
            onDropdownHide: function() {
                alert('onDropdownHide event fired');
            }
        });


        



        // Advanced examples
        // ------------------------------

        // Simulate selections
        $('.multiselect-simulate-selections').multiselect({
            onChange: function(option, checked) {
                var values = [];
                $('.multiselect-simulate-selections option').each(function() {
                    if ($(this).val() !== option.val()) {
                        values.push($(this).val());
                    }
                });

                $('.multiselect-simulate-selections').multiselect('deselect', values);
            }
        });

        // Limit the number of selected options
        $('.multiselect-limit-options').multiselect({
            onChange: function(option, checked) {
                // Get selected options.
                var selectedOptions = $('.multiselect-limit-options option:selected');
 
                if (selectedOptions.length >= 3) {
                    // Disable all other checkboxes.
                    var nonSelectedOptions = $('.multiselect-limit-options option').filter(function() {
                        return !$(this).is(':selected');
                    });
 
                    nonSelectedOptions.each(function() {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', true);
                        input.parents('.multiselect-item').addClass('disabled');
                    });
                }
                else {
                    // Enable all checkboxes.
                    $('.multiselect-limit-options option').each(function() {
                        var input = $('input[value="' + $(this).val() + '"]');
                        input.prop('disabled', false);
                        input.parents('.multiselect-item').removeClass('disabled');
                    });
                }
            }
        });


        // Templates
        $('.multiselect-templates').multiselect({
            templates: {
                divider: '<div class="multiselect-item dropdown-divider border-danger"></div>'
            }
        });


        //
        // Display values
        //

        // Initialize
        $('.multiselect-display-values').multiselect();

        // Select options
        $('.multiselect-display-values-select').on('click', function() {
            $('.multiselect-display-values').multiselect('select', 'cheese');
            $('.multiselect-display-values').multiselect('select', 'tomatoes');

            $('.values-area').addClass('alert alert-info').text('Selected: ' + $('.multiselect-display-values').val().join(', '));
        });

        // Deselect options
        $('.multiselect-display-values-deselect').on('click', function() {
            $('.multiselect-display-values').multiselect('deselect', 'cheese');
            $('.multiselect-display-values').multiselect('deselect', 'tomatoes');

            $('.values-area').addClass('alert alert-info').text('Selected: ' + $('.multiselect-display-values').val() > 0 ? $('.multiselect-display-values').val().join(', ') : 'Nothing selected');
        });


        //
        // Toggle selection
        //

        // Select all/Deselect all
        function multiselect_selected($el) {
            var ret = true;
            $('option', $el).each(function(element) {
                if (!!!$(this).prop('selected')) {
                    ret = false;
                }
            });
            return ret;
        }
        function multiselect_selectAll($el) {
            $('option', $el).each(function(element) {
                $el.multiselect('select', $(this).val());
            });
        }
        function multiselect_deselectAll($el) {
            $('option', $el).each(function(element) {
                $el.multiselect('deselect', $(this).val());
            });
        }
        function multiselect_toggle($el, $btn) {
            if (multiselect_selected($el)) {
                multiselect_deselectAll($el);
                $btn.text('Select All');
            }
            else {
                multiselect_selectAll($el);
                $btn.text('Deselect All');
            }
        }

        // Initialize
        $('.multiselect-toggle-selection').multiselect();

        // Toggle selection on button click
        $('.multiselect-toggle-selection-button').on('click', function(e) {
            e.preventDefault();
            multiselect_toggle($('.multiselect-toggle-selection'), $(this));
        });


        //
        // Order options
        //

        var orderCount = 0;

        // Initialize
        $('.multiselect-order-options').multiselect({
            buttonText: function(options) {
                if (options.length == 0) {
                    return 'None selected';
                }
                else if (options.length > 3) {
                    return options.length + ' selected';
                }
                else {
                    var selected = [];
                    options.each(function() {
                        selected.push([$(this).text(), $(this).data('order')]);
                    });

                    selected.sort(function(a, b) {
                        return a[1] - b[1];
                    });

                    var text = '';
                    for (var i = 0; i < selected.length; i++) {
                        text += selected[i][0] + ', ';
                    }

                    return text.substr(0, text.length -2);
                }
            },
            onChange: function(option, checked) {
                if (checked) {
                    orderCount++;
                    $(option).data('order', orderCount);
                }
                else {
                    $(option).data('order', '');
                }
            }
        });
     
        // Order selected options on button click
        $('.multiselect-order-options-button').on('click', function() {
            var selected = [];
            $('.multiselect-order-options option:selected').each(function() {
                selected.push([$(this).val(), $(this).data('order')]);
            });

            selected.sort(function(a, b) {
                return a[1] - b[1];
            });

            var text = '';
            for (var i = 0; i < selected.length; i++) {
                text += selected[i][0] + ', ';
            }
            text = text.substring(0, text.length - 2);

            alert(text);
        });


        //
        // Reset selections
        //

        // Initialize
        $('.multiselect-reset').multiselect();

        // Reset using reset button
        $('#multiselect-reset-form').on('reset', function() {
            $('.multiselect-reset option:selected').each(function() {
                $(this).prop('selected', false);
            })

            $('.multiselect-reset').multiselect('refresh');
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentMultiselect();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    BootstrapMultiselect.init();
});
