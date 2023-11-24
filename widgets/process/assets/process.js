(function($){

    'use strict';
  
    const processAppearAnimation = ($scope, $) => {
        if( $scope.length > 0 ){

              // Get the section element
            const section = document.querySelector('.designer--process-has-appear');

            // Function to add the class when the section is scrolled into view
            function addClassOnScroll() {
            // Get the position of the section relative to the viewport
            const rect = section.getBoundingClientRect();

            // Check if the section is visible in the viewport
            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                // Add the class to the section
                section.classList.add('designer-process--appeared');

                // Remove the scroll event listener since the class has been added
                window.removeEventListener('scroll', addClassOnScroll);
            }
            }

            // Check if the section is initially visible
            addClassOnScroll();

            // Attach the scroll event listener to the window
            window.addEventListener('scroll', addClassOnScroll);

        }
  
           
           
    }
    
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/process.default', processAppearAnimation );
    });

})(jQuery);