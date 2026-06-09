/* ================================
   COHERENCE TESTIMONIAL SCRIPT
   ================================ */

(function() {
    'use strict';

    class CoherenceTestimonial {
        constructor(element) {
            this.wrapper = element;
            this.cards = this.wrapper.querySelectorAll('.coherence-testimonial-card');
            this.init();
        }

        async init() {
            // Ajouter des animations au chargement
            this.cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                    card.style.transition = 'all 0.5s ease';
                }, index * 100);
            });

            // Initialiser Swiper si c'est un carrousel
            if (this.wrapper.classList.contains('coherence-testimonial-carousel')) {
                let SwiperConstructor = typeof Swiper !== 'undefined' ? Swiper : null;
                
                // Si Swiper n'est pas encore disponible globalement, essayer de le charger depuis Elementor
                if (!SwiperConstructor && window.elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                    SwiperConstructor = elementorFrontend.utils.swiper;
                }

                if (SwiperConstructor) {
                    this.initSwiper(SwiperConstructor);
                } else {
                    // Fallback au cas où Swiper charge de manière asynchrone
                    document.addEventListener('elementor/frontend/init', () => {
                        if (window.elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                            this.initSwiper(elementorFrontend.utils.swiper);
                        }
                    });
                }
            }
        }

        initSwiper(SwiperLib) {
            const autoplayAttr = this.wrapper.dataset.autoplay === 'true';
            const loopAttr = this.wrapper.dataset.loop === 'true';
            const showArrows = this.wrapper.dataset.arrows === 'true';
            const showDots = this.wrapper.dataset.dots === 'true';
            const cols = parseInt(this.wrapper.dataset.cols) || 3;

            const swiperOptions = {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: loopAttr,
                grabCursor: true,
                breakpoints: {
                    768: {
                        slidesPerView: Math.min(2, cols)
                    },
                    1024: {
                        slidesPerView: cols
                    }
                }
            };

            if (autoplayAttr) {
                swiperOptions.autoplay = {
                    delay: 4500,
                    disableOnInteraction: false
                };
            }

            if (showDots) {
                swiperOptions.pagination = {
                    el: this.wrapper.querySelector('.swiper-pagination'),
                    clickable: true
                };
            }

            if (showArrows) {
                swiperOptions.navigation = {
                    nextEl: this.wrapper.querySelector('.swiper-button-next'),
                    prevEl: this.wrapper.querySelector('.swiper-button-prev')
                };
            }

            // Instancier Swiper
            new SwiperLib(this.wrapper, swiperOptions);
        }
    }

    // Initialiser au chargement du DOM
    function initTestimonials() {
        const wrappers = document.querySelectorAll('.coherence-testimonial-wrapper');
        wrappers.forEach(wrapper => {
            new CoherenceTestimonial(wrapper);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTestimonials);
    } else {
        initTestimonials();
    }

    // Pour Elementor Editor
    if (window.elementorFrontend) {
        elementorFrontend.hooks.addAction('frontend/element_ready/coherence_testimonial.default', function($scope) {
            const wrapper = $scope.find('.coherence-testimonial-wrapper')[0];
            if (wrapper) {
                // Attendre un court instant dans l'éditeur pour s'assurer que Swiper est chargé
                setTimeout(() => {
                    new CoherenceTestimonial(wrapper);
                }, 200);
            }
        });
    }
})();
