import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "item", "nextButton", "previousButton", 
        "mobileNextButton", "mobilePreviousButton", 
        "reviewsCarousel"
    ];
    static values = {
        autoScrollInterval: Number // Interval for automatic scrolling
    }

    connect() {
        this.currentIndex = 0;
        this.showItem(this.currentIndex); // Display the initial item
        this.startAutoScroll(); // Start automatic scrolling
        this.next(); // Move to the next item immediately

        // Create an observer for the reviews section
        this.observer = new IntersectionObserver(this.handleIntersection.bind(this), {
            threshold: 0.1
        });

        // Observe the reviews section
        this.observer.observe(this.reviewsCarouselTarget);
    }

    disconnect() {
        this.stopAutoScroll(); // Stop automatic scrolling when controller disconnects
        this.observer.disconnect(); // Disconnect the observer
    }

    startAutoScroll() {
        // Start the interval for automatic scrolling
        this.autoScrollIntervalId = setInterval(() => {
            this.next();
        }, this.autoScrollIntervalValue || 15000); // Default to 15 seconds if no value provided
    }

    stopAutoScroll() {
        // Clear the automatic scrolling interval
        clearInterval(this.autoScrollIntervalId);
    }

    next() {
        this.stopAutoScroll(); // Stop auto scroll to prevent conflicts
        let nextIndex = (this.currentIndex + 1) % this.itemTargets.length; // Calculate the next index
        this.transitionItems(this.currentIndex, nextIndex, "next"); // Transition to the next item
        this.currentIndex = nextIndex; // Update current index
        this.startAutoScroll(); // Restart auto scroll
    }

    previous() {
        this.stopAutoScroll(); // Stop auto scroll to prevent conflicts
        let prevIndex = (this.currentIndex - 1 + this.itemTargets.length) % this.itemTargets.length; // Calculate the previous index
        this.transitionItems(this.currentIndex, prevIndex, "previous"); // Transition to the previous item
        this.currentIndex = prevIndex; // Update current index
        this.startAutoScroll(); // Restart auto scroll
    }

    transitionItems(currentIndex, newIndex) {
        const currentItem = this.itemTargets[currentIndex];
        const newItem = this.itemTargets[newIndex];

        // Update classes to transition items
        currentItem.classList.remove("active");
        currentItem.classList.add("previous");
        newItem.classList.add("next");

        // Force a reflow to apply classes immediately
        void newItem.offsetWidth;

        // Finalize class changes for new item
        newItem.classList.remove("next");
        newItem.classList.add("active");
    }

    showItem(index) {
        // Show only the item at the specified index
        this.itemTargets.forEach((item, idx) => {
            item.classList.toggle("active", idx === index);
            if (idx !== index) {
                item.classList.remove("previous", "next");
            }
        });
    }

    handleIntersection(entries) {
        // Handle intersection observer events
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Move to the next item shortly after intersection
                setTimeout(() => {
                    this.next();
                }, 1500);
            }
        });
    }
}
