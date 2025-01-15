import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "item", "nextButton", "previousButton",
        "mobileNextButton", "mobilePreviousButton",
        "reviewsCarousel"
    ]

    static values = {
        autoScrollInterval: { type: Number, default: 8000 },
        initialDelay: { type: Number, default: 1500 },
        threshold: { type: Number, default: 0.1 }
    }

    initialize() {
        this.currentIndex = 0;
        this.boundHandleIntersection = this.handleIntersection.bind(this);
    }

    connect() {
        this.initializeCarousel();
        this.initializeObserver();
    }

    disconnect() {
        this.stopAutoScroll();
        this.observer?.disconnect();
    }

    initializeCarousel() {
        this.showItem(this.currentIndex);
        this.startAutoScroll();
        requestAnimationFrame(() => this.next());
    }

    initializeObserver() {
        this.observer = new IntersectionObserver(this.boundHandleIntersection, {
            threshold: this.thresholdValue
        });
        this.observer.observe(this.reviewsCarouselTarget);
    }

    startAutoScroll() {
        this.stopAutoScroll();
        this.autoScrollIntervalId = setInterval(() => {
            this.next();
        }, this.autoScrollIntervalValue);
    }

    stopAutoScroll() {
        if (this.autoScrollIntervalId) {
            clearInterval(this.autoScrollIntervalId);
            this.autoScrollIntervalId = null;
        }
    }

    next() {
        this.moveToIndex((this.currentIndex + 1) % this.itemTargets.length);
    }

    previous() {
        this.moveToIndex((this.currentIndex - 1 + this.itemTargets.length) % this.itemTargets.length);
    }

    moveToIndex(newIndex) {
        if (!this.isValidIndex(newIndex)) return;

        this.stopAutoScroll();
        this.transitionItems(this.currentIndex, newIndex);
        this.currentIndex = newIndex;
        this.startAutoScroll();
    }

    transitionItems(currentIndex, newIndex) {
        const currentItem = this.getItem(currentIndex);
        const newItem = this.getItem(newIndex);

        if (!currentItem || !newItem) return;

        requestAnimationFrame(() => {
            this.updateItemClasses(currentItem, newItem);
        });
    }

    getItem(index) {
        return this.isValidIndex(index) ? this.itemTargets[index] : null;
    }

    isValidIndex(index) {
        return Number.isInteger(index) &&
            index >= 0 &&
            index < this.itemTargets.length;
    }

    updateItemClasses(currentItem, newItem) {
        currentItem.classList.remove("active");
        currentItem.classList.add("previous");

        // Force reflow with non-null operation
        const reflow = newItem.offsetHeight;

        newItem.classList.add("next");
        requestAnimationFrame(() => {
            newItem.classList.remove("next");
            newItem.classList.add("active");
        });
    }

    showItem(index) {
        if (!this.isValidIndex(index)) return;

        this.itemTargets.forEach((item, idx) => {
            const isActive = idx === index;
            item.classList.toggle("active", isActive);
            if (!isActive) {
                item.classList.remove("previous", "next");
            }
        });
    }

    handleIntersection = (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    requestAnimationFrame(() => this.next());
                }, this.initialDelayValue);
            }
        });
    }
}