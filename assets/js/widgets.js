(function($) {
    'use strict';
    
    // Widget JavaScript initialization
    $(window).on('elementor/frontend/init', function() {
        
        // Example: Initialize widget-specific functionality
        elementorFrontend.hooks.addAction('frontend/element_ready/example-widget-1.default', function($scope) {
            // Widget 1 specific JS
            console.log('Example Widget 1 initialized');
        });
        
        elementorFrontend.hooks.addAction('frontend/element_ready/example-widget-2.default', function($scope) {
            // Widget 2 specific JS
            console.log('Example Widget 2 initialized');
        });
        
    });
    
})(jQuery);