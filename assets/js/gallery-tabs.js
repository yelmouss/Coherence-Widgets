/* ================================
   COHERENCE GALLERY TABS SCRIPT
   ================================ */

(function() {
    'use strict';

    class CoherenceGalleryTabs {
        constructor(wrapper) {
            this.wrapper = wrapper;
            this.navButtons = this.wrapper.querySelectorAll('.gallery-tabs-nav-btn');
            this.panes = this.wrapper.querySelectorAll('.gallery-tabs-grid-pane');
            this.portfolioCards = this.wrapper.querySelectorAll('.gallery-tabs-card.type-portfolio');
            this.overlay = this.wrapper.querySelector('.project-details-overlay');
            this.overlayBackdrop = this.wrapper.querySelector('.project-overlay-backdrop');
            this.overlayContainer = this.wrapper.querySelector('.project-overlay-container');
            this.overlayCloseBtn = this.wrapper.querySelector('.project-overlay-close-btn');
            this.overlayContent = this.wrapper.querySelector('.project-overlay-content');
            
            this.init();
        }

        init() {
            // Tabs navigation logic
            this.setupTabsNavigation();

            // Portfolio overlay triggers
            this.setupPortfolioTriggers();

            // Setup global close events for the overlay
            this.setupOverlayCloseEvents();

            // Bind Fancybox to elements
            this.initFancybox();
        }

        setupTabsNavigation() {
            const handleTabSwitch = (e, button) => {
                e.preventDefault();
                const targetId = button.getAttribute('data-tab-target');
                
                // Toggle active button
                this.navButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Toggle active pane
                this.panes.forEach(pane => {
                    if (pane.id === targetId) {
                        pane.classList.add('active');
                    } else {
                        pane.classList.remove('active');
                    }
                });
            };

            this.navButtons.forEach(button => {
                // Click for frontend
                button.addEventListener('click', (e) => {
                    handleTabSwitch(e, button);
                });
                // Mousedown to bypass Elementor editor click blocking
                button.addEventListener('mousedown', (e) => {
                    if (e.button === 0) { // Left click only
                        handleTabSwitch(e, button);
                    }
                });
            });
        }

        setupPortfolioTriggers() {
            const handlePortfolioOpen = (e, card) => {
                e.preventDefault();
                const jsonScript = card.querySelector('.project-details-json');
                if (!jsonScript) return;

                try {
                    const projectData = JSON.parse(jsonScript.textContent);
                    this.openProjectOverlay(projectData);
                } catch (error) {
                    console.error('Error parsing project data:', error);
                }
            };

            this.portfolioCards.forEach(card => {
                card.addEventListener('click', (e) => {
                    handlePortfolioOpen(e, card);
                });
                card.addEventListener('mousedown', (e) => {
                    if (e.button === 0) { // Left click only
                        handlePortfolioOpen(e, card);
                    }
                });
            });
        }

        openProjectOverlay(projectData) {
            if (!this.overlay || !this.overlayContent) return;

            // Generate content HTML
            let galleryHtml = '';
            if (projectData.gallery && projectData.gallery.length > 0) {
                galleryHtml = `<div class="project-overlay-gallery-grid">`;
                projectData.gallery.forEach(img => {
                    galleryHtml += `
                        <a href="${img.url}" data-fancybox="project-gal-${projectData.id}" data-caption="${img.alt}" class="project-overlay-image-link">
                            <img src="${img.url}" alt="${img.alt || ''}" loading="lazy">
                        </a>
                    `;
                });
                galleryHtml += `</div>`;
            } else {
                galleryHtml = `<p class="project-overlay-no-images">Aucune image dans la galerie du projet.</p>`;
            }

            this.overlayContent.innerHTML = `
                <div class="project-overlay-header">
                    <span class="project-overlay-subtitle">${projectData.subtitle || ''}</span>
                    <h3 class="project-overlay-title">${projectData.title}</h3>
                </div>
                ${galleryHtml}
            `;

            // Open overlay with slide animation
            this.overlay.classList.add('active');
            this.overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden'; // Lock background scroll

            // Re-bind Fancybox for the newly generated project gallery elements
            this.initFancybox();
        }

        closeProjectOverlay() {
            if (!this.overlay) return;
            this.overlay.classList.remove('active');
            this.overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = ''; // Unlock background scroll
        }

        setupOverlayCloseEvents() {
            if (this.overlayCloseBtn) {
                this.overlayCloseBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.closeProjectOverlay();
                });
            }

            if (this.overlayBackdrop) {
                this.overlayBackdrop.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.closeProjectOverlay();
                });
            }

            // Close on escape key press
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.overlay && this.overlay.classList.contains('active')) {
                    this.closeProjectOverlay();
                }
            });
        }

        initFancybox() {
            if (typeof Fancybox !== 'undefined') {
                // Binding Fancybox structure. We can use Fancybox.bind() to target the link items
                Fancybox.bind('[data-fancybox]', {
                    Toolbar: {
                        display: {
                            left: [],
                            middle: [],
                            right: ["slideshow", "download", "thumbs", "close"],
                        },
                    },
                    Images: {
                        protected: true
                    }
                });
            }
        }
    }

    // Expose class globally
    window.CoherenceGalleryTabs = CoherenceGalleryTabs;

    // Initialize all widgets on DOMContentLoaded
    function initGalleryTabsWidgets() {
        const wrappers = document.querySelectorAll('.coherence-gallery-tabs-wrapper');
        wrappers.forEach(wrapper => {
            new CoherenceGalleryTabs(wrapper);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGalleryTabsWidgets);
    } else {
        initGalleryTabsWidgets();
    }

    // Support Elementor Editor Preview live reload/setup
    if (window.elementorFrontend) {
        elementorFrontend.hooks.addAction('frontend/element_ready/coherence_gallery_tabs.default', function($scope) {
            const wrapper = $scope.find('.coherence-gallery-tabs-wrapper')[0];
            if (wrapper) {
                new CoherenceGalleryTabs(wrapper);
            }
        });
    }
})();
