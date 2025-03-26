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
        this.wrapperTarget.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
        this.wrapperTarget.addEventListener('touchend', this.handleTouchEnd.bind(this), { passive: true });
        this.initializeObserver();
        this.setupInitialState();
        this.startAutoScroll();
    }

    disconnect() {
        this.stopAutoScroll();
        this.observer?.disconnect();
        this.wrapperTarget.removeEventListener('touchstart', this.handleTouchStart.bind(this));
        this.wrapperTarget.removeEventListener('touchend', this.handleTouchEnd.bind(this));
    }

    setupInitialState() {
        this.updateSlidePositions();
        this.updateIndicators();
    }

    updateSlidePositions() {
        this.itemTargets.forEach((item, idx) => {
            item.classList.remove('active', 'prev', 'next', 'transition-active');

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
            index = parseInt(index.currentTarget.dataset.index, 10);
        }

        if (index === this.currentIndex || this.isAnimating) return;

        this.isAnimating = true;
        this.stopAutoScroll();

        this.itemTargets.forEach(item => {
            item.classList.add('transition-active');
        });

        const oldIndex = this.currentIndex;
        this.currentIndex = index;
        this.updateSlidePositions();
        this.updateIndicators();

        setTimeout(() => {
            this.itemTargets.forEach(item => {
                item.classList.remove('transition-active');
            });

            this.isAnimating = false;
            this.startAutoScroll();
        }, 600);
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

    handleTouchStart(event) {
        this.touchStartX = event.changedTouches[0].screenX;
    }

    handleTouchEnd(event) {
        this.touchEndX = event.changedTouches[0].screenX;
        this.handleSwipe();
    }

    handleSwipe() {
        const swipeThreshold = 50;
        const swipeDistance = this.touchEndX - this.touchStartX;

        if (swipeDistance > swipeThreshold) {
            this.previous();
        } else if (swipeDistance < -swipeThreshold) {
            this.next();
        }
    }
}