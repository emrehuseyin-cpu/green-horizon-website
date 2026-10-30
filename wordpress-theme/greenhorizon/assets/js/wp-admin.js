/**
 * Green Horizon WP Admin Tabs & Media Picker
 */
jQuery(document).ready(function($) {
    // Tabs switcher
    $('.gh-tab-btn').on('click', function() {
        var tabId = $(this).data('tab');
        $('.gh-tab-btn').removeClass('active');
        $('.gh-tab-content').removeClass('active');
        $(this).addClass('active');
        $('#tab-' + tabId).addClass('active');
    });

    // Native WordPress Media Uploader integration
    $('.gh-media-upload-btn').on('click', function(e) {
        e.preventDefault();
        var targetInput = $(this).data('target');
        var mediaType = $(this).data('type') || '';

        var mediaFrame = wp.media({
            title: 'Select or Upload Media File',
            button: { text: 'Use this media' },
            library: mediaType ? { type: mediaType } : {},
            multiple: false
        });

        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            $(targetInput).val(attachment.url);
        });

        mediaFrame.open();
    });
});
