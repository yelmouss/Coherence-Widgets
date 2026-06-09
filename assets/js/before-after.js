/* ================================
   COHERENCE BEFORE/AFTER SCRIPT
   ================================ */

(function() {
    'use strict';

    class CoherenceBeforeAfter {
        constructor(element) {
            this.wrapper = element;
            this.container = this.wrapper.querySelector('.coherence-ba-container');
            this.beforeLayer = this.wrapper.querySelector('.coherence-ba-before');
            this.handle = this.wrapper.querySelector('.coherence-ba-handle');
            
            this.interactionType = this.wrapper.dataset.interaction || 'mouse';
            this.initialPosition = parseInt(this.wrapper.dataset.initialPosition) || 50;
            
            this.isDragging = false;
            this.currentPosition = this.initialPosition;
            
            this.init();
        }

        init() {
            // Définir la position initiale
            this.setPosition(this.initialPosition);
            
            // Ajouter les écouteurs d'événements selon le type d'interaction
            switch(this.interactionType) {
                case 'mouse':
                    this.setupMouseInteraction();
                    break;
                case 'click':
                    this.setupClickInteraction();
                    break;
                case 'drag':
                    this.setupDragInteraction();
                    break;
                default:
                    this.setupMouseInteraction();
            }
            
            // Support tactile
            this.setupTouchInteraction();
            
            // Redimensionner au changement de fenêtre
            window.addEventListener('resize', () => this.updatePosition());
        }

        setupMouseInteraction() {
            this.container.addEventListener('mousemove', (e) => {
                const rect = this.container.getBoundingClientRect();
                const position = ((e.clientX - rect.left) / rect.width) * 100;
                this.setPosition(position);
            });

            this.container.addEventListener('mouseleave', () => {
                this.setPosition(this.initialPosition);
            });
        }

        setupClickInteraction() {
            this.container.addEventListener('click', (e) => {
                const rect = this.container.getBoundingClientRect();
                const position = ((e.clientX - rect.left) / rect.width) * 100;
                this.setPosition(position);
            });
        }

        setupDragInteraction() {
            this.container.addEventListener('mousedown', () => {
                this.isDragging = true;
            });

            document.addEventListener('mouseup', () => {
                this.isDragging = false;
            });

            document.addEventListener('mousemove', (e) => {
                if (!this.isDragging) return;
                
                const rect = this.container.getBoundingClientRect();
                const position = ((e.clientX - rect.left) / rect.width) * 100;
                this.setPosition(Math.max(0, Math.min(100, position)));
            });
        }

        setupTouchInteraction() {
            this.container.addEventListener('touchstart', () => {
                this.isDragging = true;
            });

            document.addEventListener('touchend', () => {
                this.isDragging = false;
            });

            document.addEventListener('touchmove', (e) => {
                if (!this.isDragging) return;
                
                const touch = e.touches[0];
                const rect = this.container.getBoundingClientRect();
                const position = ((touch.clientX - rect.left) / rect.width) * 100;
                this.setPosition(Math.max(0, Math.min(100, position)));
            });
        }

        setPosition(percentage) {
            percentage = Math.max(0, Math.min(100, percentage));
            this.currentPosition = percentage;
            
            this.beforeLayer.style.width = percentage + '%';
            this.handle.style.left = percentage + '%';
            
            // Mettre à jour la position des labels
            const beforeLabel = this.wrapper.querySelector('.coherence-ba-before-label');
            const afterLabel = this.wrapper.querySelector('.coherence-ba-after-label');
            
            if (beforeLabel) {
                beforeLabel.style.opacity = percentage > 20 ? 1 : 0.5;
            }
            if (afterLabel) {
                afterLabel.style.opacity = percentage < 80 ? 1 : 0.5;
            }
        }

        updatePosition() {
            // Maintenir la position actuelle lors du redimensionnement
            this.setPosition(this.currentPosition);
        }
    }

    // Initialiser tous les widgets Before/After au chargement du DOM
    function initBeforeAfterWidgets() {
        const wrappers = document.querySelectorAll('.coherence-ba-wrapper');
        wrappers.forEach(wrapper => {
            new CoherenceBeforeAfter(wrapper);
        });
    }

    // Attendre que le DOM soit chargé
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBeforeAfterWidgets);
    } else {
        initBeforeAfterWidgets();
    }

    // Pour Elementor Editor
    if (window.elementorFrontend) {
        elementorFrontend.hooks.addAction('frontend/element_ready/coherence_before_after.default', function($scope) {
            const wrapper = $scope.find('.coherence-ba-wrapper')[0];
            if (wrapper) {
                new CoherenceBeforeAfter(wrapper);
            }
        });
    }
})();
