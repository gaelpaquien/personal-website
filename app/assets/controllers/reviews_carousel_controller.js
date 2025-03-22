import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "item", "indicator", "reviewsCarousel", "wrapper"
    ]

    static values = {
        autoScrollInterval: { type: Number, default: 8000 },
        threshold: { type: Number, default: 0.1 }
    }

    initialize() {
        this.currentIndex = 0;
        this.isAnimating = false;
        this.boundHandleIntersection = this.handleIntersection.bind(this);
        this.itemCount = 0;
        this.autoScrollId = null;
        this.touchStartX = 0;
        this.touchEndX = 0;
    }

    connect() {
        this.itemCount = this.itemTargets.length;
        if (this.itemCount === 0) return;

        // Ajouter les événements tactiles pour le swipe
        this.wrapperTarget.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
        this.wrapperTarget.addEventListener('touchend', this.handleTouchEnd.bind(this), { passive: true });

        this.initializeObserver();
        this.setupInitialState();
        this.startAutoScroll();
    }

    disconnect() {
        this.stopAutoScroll();
        this.observer?.disconnect();

        // Supprimer les événements tactiles
        this.wrapperTarget.removeEventListener('touchstart', this.handleTouchStart.bind(this));
        this.wrapperTarget.removeEventListener('touchend', this.handleTouchEnd.bind(this));
    }

    setupInitialState() {
        // Définir la position initiale de tous les slides
        this.updateSlidePositions();

        // Mettre à jour les indicateurs
        this.updateIndicators();
    }

    updateSlidePositions() {
        this.itemTargets.forEach((item, idx) => {
            // Réinitialiser toutes les classes
            item.classList.remove('active', 'prev', 'next', 'transition-active');

            // Appliquer la classe appropriée
            const position = this.getItemPosition(idx);
            if (position) {
                item.classList.add(position);
            }
        });
    }

    getItemPosition(idx) {
        if (idx === this.currentIndex) {
            return 'active';
        } else if (idx === this.getPreviousIndex()) {
            return 'prev';
        } else if (idx === this.getNextIndex()) {
            return 'next';
        }
        return null;
    }

    getPreviousIndex() {
        return (this.currentIndex - 1 + this.itemCount) % this.itemCount;
    }

    getNextIndex() {
        return (this.currentIndex + 1) % this.itemCount;
    }

    initializeObserver() {
        this.observer = new IntersectionObserver(this.boundHandleIntersection, {
            threshold: this.thresholdValue
        });
        this.observer.observe(this.reviewsCarouselTarget);
    }

    startAutoScroll() {
        this.stopAutoScroll();
        this.autoScrollId = setInterval(() => {
            this.next();
        }, this.autoScrollIntervalValue);
    }

    stopAutoScroll() {
        if (this.autoScrollId) {
            clearInterval(this.autoScrollId);
            this.autoScrollId = null;
        }
    }

    next() {
        if (this.isAnimating) return;
        this.goToSlide(this.getNextIndex());
    }

    previous() {
        if (this.isAnimating) return;
        this.goToSlide(this.getPreviousIndex());
    }

    clickSlide(event) {
        const clickedItem = event.currentTarget;
        const clickedIndex = parseInt(clickedItem.dataset.index, 10);

        if (clickedIndex === this.currentIndex) return;

        if (clickedIndex === this.getPreviousIndex()) {
            this.previous();
        } else if (clickedIndex === this.getNextIndex()) {
            this.next();
        } else {
            this.goToSlide(clickedIndex);
        }
    }

    goToSlide(index) {
        if (typeof index === 'object' && index.currentTarget) {
            // Si c'est un événement, récupérer l'index depuis le dataset
            index = parseInt(index.currentTarget.dataset.index, 10);
        }

        if (index === this.currentIndex || this.isAnimating) return;

        this.isAnimating = true;
        this.stopAutoScroll();

        // Ajouter la classe de transition à tous les éléments
        this.itemTargets.forEach(item => {
            item.classList.add('transition-active');
        });

        // Stocker l'ancien index
        const oldIndex = this.currentIndex;

        // Mettre à jour l'index courant
        this.currentIndex = index;

        // Mettre à jour les positions des slides
        this.updateSlidePositions();

        // Mettre à jour les indicateurs
        this.updateIndicators();

        // Attendre la fin de l'animation
        setTimeout(() => {
            // Enlever la classe de transition
            this.itemTargets.forEach(item => {
                item.classList.remove('transition-active');
            });

            this.isAnimating = false;
            this.startAutoScroll();
        }, 600);  // Correspond à la durée de transition dans le CSS
    }

    updateIndicators() {
        if (!this.hasIndicatorTarget) return;

        this.indicatorTargets.forEach((indicator, idx) => {
            indicator.classList.toggle('active', idx === this.currentIndex);
        });
    }

    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting && !this.autoScrollId) {
                this.startAutoScroll();
            } else if (!entry.isIntersecting && this.autoScrollId) {
                this.stopAutoScroll();
            }
        });
    }

    // Gestion du swipe sur mobile
    handleTouchStart(event) {
        this.touchStartX = event.changedTouches[0].screenX;
    }

    handleTouchEnd(event) {
        this.touchEndX = event.changedTouches[0].screenX;
        this.handleSwipe();
    }

    handleSwipe() {
        const swipeThreshold = 50; // Seuil en pixels pour considérer qu'il y a un swipe
        const swipeDistance = this.touchEndX - this.touchStartX;

        if (swipeDistance > swipeThreshold) {
            // Swipe de gauche à droite -> slide précédent
            this.previous();
        } else if (swipeDistance < -swipeThreshold) {
            // Swipe de droite à gauche -> slide suivant
            this.next();
        }
    }
}