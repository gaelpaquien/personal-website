import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["overlay", "menu", "openButton", "closeButton", "dropdown", "arrow"];

    connect() {
        this.headerHeadband = document.querySelector('.header__headband');
        this.footer = document.querySelector('footer');
        this.mainContent = document.querySelector('main');

        // Initial styles to prepare for transition
        this.mainContent.style.transition = 'width 0.5s';
        this.mainContent.style.width = '100%';
        this.menuTarget.style.transition = 'width 0.5s';
        this.menuTarget.style.width = '0%';

        document.addEventListener('DOMContentLoaded', this.handleScrollToAnchor);
        this.mainContent.addEventListener('click', this.handleOutsideClick);
        this.overlayTarget.addEventListener('click', this.handleOutsideClick);
        window.addEventListener('resize', this.handleWindowResize);
    }

    disconnect() {
        // Clean up the event listener when the controller is disconnected
        document.removeEventListener('DOMContentLoaded', this.handleScrollToAnchor);
        this.mainContent.removeEventListener('click', this.handleOutsideClick);
        this.overlayTarget.removeEventListener('click', this.handleOutsideClick);
        window.removeEventListener('resize', this.handleWindowResize);
    }

    open() {
        this.openButtonTarget.classList.add('rotate-up');

        document.body.style.overflow = 'hidden';

        this.headerHeadband.style.display = 'none';
        this.overlayTarget.style.display = 'block';
        this.menuTarget.style.borderLeft = 'solid 0.1rem var(--color-text)';

        // Adjust styles based on breakpoints
        if (window.innerWidth >= 1200) {
            this.menuTarget.style.top = '6.2rem';
            this.menuTarget.style.width = '25%';
            this.mainContent.style.width = '75%';
        } else if (window.innerWidth >= 768) {
            this.menuTarget.style.top = '5.5rem';
            this.menuTarget.style.width = '40%';
            this.mainContent.style.width = '60%';
        } else {
            this.menuTarget.style.top = '5.5rem';
            this.menuTarget.style.width = '70%';
            this.mainContent.style.width = '100%';
        }

        setTimeout(() => {
            // Toggle button visibility after animation
            this.openButtonTarget.style.display = 'none';
            this.closeButtonTarget.style.display = 'block';
            this.closeButtonTarget.classList.remove('rotate-down');
            this.openButtonTarget.classList.remove('rotate-up');
        }, 500);
    }

    close() {
        this.closeButtonTarget.classList.add('rotate-down');

        document.body.style.overflow = 'auto';

        this.menuTarget.style.width = "0%";
        this.mainContent.style.width = '100%';
        this.overlayTarget.style.display = 'none';
        this.menuTarget.style.borderLeft = 'none';

        setTimeout(() => {
            // Toggle button and header headband visibility after animation
            this.headerHeadband.style.display = 'flex';
            this.closeButtonTarget.style.display = 'none';
            this.openButtonTarget.style.display = 'block';
            this.closeButtonTarget.classList.remove('rotate-down');
            this.openButtonTarget.classList.remove('rotate-up');
        }, 500);
    }

    toggleDropdown(event) {
        const listItem = event.currentTarget.closest('.navigation__container-list-item');
        const dropdown = listItem.querySelector('.navigation__container-list-item-about-dropdown');
        const arrow = listItem.querySelector('svg');

        dropdown.classList.toggle('active');
        arrow.classList.toggle('rotate-down-effects');

        if (dropdown.classList.contains('active')) {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }

        // Close other dropdowns
        const otherDropdowns = this.element.querySelectorAll('.navigation__container-list-item-about-dropdown');
        otherDropdowns.forEach((item) => {
            if (item !== dropdown) {
                item.style.display = 'none';
                item.classList.remove('active');
                const otherArrow = item.closest('.navigation__container-list-item').querySelector('svg');
                otherArrow.classList.remove('rotate-down-effects');
            }
        });
    }

    redirect(event) {
        const url = event.currentTarget.dataset.url;
        const anchor = event.currentTarget.dataset.urlAnchor;

        if (url) {
            this.close();

            setTimeout(() => {
                if (anchor) {
                    localStorage.setItem('anchor', anchor);
                    window.location.href = url;
                } else {
                    window.location.href = url;
                }
            }, 250); // Delay to allow the close animation to finish
        }
    }

    handleScrollToAnchor = () => {
        const anchor = localStorage.getItem('anchor');
        if (anchor) {
            localStorage.removeItem('anchor');
            setTimeout(() => {
                const targetElement = document.querySelector(`#${anchor}`);
                if (targetElement) {
                    const headerHeight = document.querySelector('.header') ? document.querySelector('.header').offsetHeight : 0;
                    const extraOffset = 20;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight + extraOffset;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }, 100); // Delay to ensure the DOM is rendered
        }
    }

    handleOutsideClick = (event) => {
        if (this.mainContent.contains(event.target) || this.overlayTarget.contains(event.target)) {
            this.close();
        }
    }

    handleWindowResize = () => {
        if (this.menuTarget.style.width !== "0%") {
            this.close();
        }
    }
}
