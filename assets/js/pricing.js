/* ================================
   COHERENCE PRICING SCRIPT
   ================================ */

(function() {
    'use strict';

    class CoherencePricing {
        constructor(element) {
            this.card = element;
            this.toggle = this.card.querySelector('.coherence-pricing-switch-input');
            this.monthlyVal = this.card.querySelector('.coherence-pricing-val-monthly');
            this.yearlyVal = this.card.querySelector('.coherence-pricing-val-yearly');
            this.billingInfo = this.card.querySelector('.coherence-pricing-billing-info');
            
            if (this.toggle) {
                this.init();
            }
        }

        init() {
            // Set initial styles for transitions
            if (this.monthlyVal) {
                this.monthlyVal.style.transition = 'opacity 0.2s ease';
                this.monthlyVal.style.opacity = '1';
            }
            if (this.yearlyVal) {
                this.yearlyVal.style.transition = 'opacity 0.2s ease';
                this.yearlyVal.style.opacity = '0';
            }
            if (this.billingInfo) {
                this.billingInfo.style.transition = 'opacity 0.2s ease';
                this.billingInfo.style.opacity = '0';
            }

            this.toggle.addEventListener('change', () => {
                this.updatePricing();
            });
        }

        updatePricing() {
            if (this.toggle.checked) {
                // Switch to Yearly
                this.card.classList.add('coherence-pricing-yearly-active');
                this.fadeToggle(this.monthlyVal, this.yearlyVal);
                if (this.billingInfo) {
                    this.billingInfo.style.display = 'block';
                    setTimeout(() => {
                        this.billingInfo.style.opacity = '1';
                    }, 20);
                }
            } else {
                // Switch to Monthly
                this.card.classList.remove('coherence-pricing-yearly-active');
                this.fadeToggle(this.yearlyVal, this.monthlyVal);
                if (this.billingInfo) {
                    this.billingInfo.style.opacity = '0';
                    setTimeout(() => {
                        this.billingInfo.style.display = 'none';
                    }, 200);
                }
            }
        }

        fadeToggle(fadeOutEl, fadeInEl) {
            if (!fadeOutEl || !fadeInEl) return;
            fadeOutEl.style.opacity = '0';
            setTimeout(() => {
                fadeOutEl.style.display = 'none';
                
                fadeInEl.style.display = 'block';
                fadeInEl.style.opacity = '0';
                setTimeout(() => {
                    fadeInEl.style.opacity = '1';
                }, 20);
            }, 200);
        }
    }

    function initPricing() {
        const cards = document.querySelectorAll('.coherence-pricing-card');
        cards.forEach(card => {
            new CoherencePricing(card);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPricing);
    } else {
        initPricing();
    }

    // Pour Elementor Editor
    if (window.elementorFrontend) {
        elementorFrontend.hooks.addAction('frontend/element_ready/coherence_pricing.default', function($scope) {
            const card = $scope.find('.coherence-pricing-card')[0];
            if (card) {
                new CoherencePricing(card);
            }
        });
    }
})();
