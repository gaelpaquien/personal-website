import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["overlay", "menu", "openButton", "closeButton", "dropdown", "arrow"]
    static values = {
        transitionDuration: { type: Number, default: 500 },
        headerHeight: { type: Number, default: 20 },
        breakpoints: {
            type: Object,
            default: {
                desktop: { width: 1200, menuWidth: 25, menuTop: 6.2 },
                tablet: { width: 768, menuWidth: 40, menuTop: 5.5 },
                mobile: { width: 0, menuWidth: 70, menuTop: 5.5 }
            }
        }
    }

    initialize() {
        this.headerHeadband = document.querySelector('.header__headband');
        this.footer = document.querySelector('footer');
        this.mainContent = document.querySelector('main');

        this.handleOutsideClick = this.handleOutsideClick.bind(this);
        this.handleWindowResize = this.handleWindowResize.bind(this);
        this.handleScrollToAnchor = this.handleScrollToAnchor.bind(this);
    }

    connect() {
        this.initializeStyles();
        this.initializeEventListeners();
    }

    disconnect() {
        this.removeEventListeners();
    }

    initializeStyles() {
        this.mainContent.style.transition = `width ${this.transitionDurationValue}ms`;
        this.mainContent.style.width = '100%';
        this.menuTarget.style.transition = `width ${this.transitionDurationValue}ms`;
        this.menuTarget.style.width = '0%';
    }

    initializeEventListeners() {
        document.addEventListener('DOMContentLoaded', this.handleScrollToAnchor);
        this.mainContent.addEventListener('click', this.handleOutsideClick);
        this.overlayTarget.addEventListener('click', this.handleOutsideClick);
        window.addEventListener('resize', this.handleWindowResize);
    }

    removeEventListeners() {
        document.removeEventListener('DOMContentLoaded', this.handleScrollToAnchor);
        this.mainContent.removeEventListener('click', this.handleOutsideClick);
        this.overlayTarget.removeEventListener('click', this.handleOutsideClick);
        window.removeEventListener('resize', this.handleWindowResize);
    }

    open() {
        this.toggleMenu(true);
        setTimeout(() => this.handleAnimationEnd(true), this.transitionDurationValue);
    }

    close() {
        this.toggleMenu(false);
        setTimeout(() => this.handleAnimationEnd(false), this.transitionDurationValue);
    }

    toggleMenu(isOpen) {
        const breakpoint = this.getCurrentBreakpoint();

        this.openButtonTarget.classList.toggle('rotate-up', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
        this.headerHeadband.style.display = isOpen ? 'none' : 'flex';
        this.overlayTarget.style.display = isOpen ? 'block' : 'none';
        this.menuTarget.style.borderLeft = isOpen ? 'solid 0.1rem var(--color-text)' : 'none';

        if (isOpen) {
            this.menuTarget.style.top = `${breakpoint.menuTop}rem`;
            this.menuTarget.style.width = `${breakpoint.menuWidth}%`;
            this.mainContent.style.width = window.innerWidth >= 768 ? `${100 - breakpoint.menuWidth}%` : '100%';
        } else {
            this.menuTarget.style.width = '0%';
            this.mainContent.style.width = '100%';
        }
    }

    handleAnimationEnd(isOpen) {
        this.openButtonTarget.style.display = isOpen ? 'none' : 'block';
        this.closeButtonTarget.style.display = isOpen ? 'block' : 'none';
        this.closeButtonTarget.classList.toggle('rotate-down', !isOpen);
        this.openButtonTarget.classList.remove('rotate-up');
    }

    getCurrentBreakpoint() {
        const { desktop, tablet, mobile } = this.breakpointsValue;
        if (window.innerWidth >= desktop.width) return desktop;
        if (window.innerWidth >= tablet.width) return tablet;
        return mobile;
    }

    toggleDropdown(event) {
        const listItem = event.currentTarget.closest('.navigation__container-list-item');
        const dropdown = listItem.querySelector('.navigation__container-list-item-about-dropdown');
        const arrow = listItem.querySelector('svg');
        const isActive = !dropdown.classList.contains('active');

        this.closeAllDropdowns();

        dropdown.classList.toggle('active', isActive);
        arrow.classList.toggle('rotate-down-effects', isActive);
        dropdown.style.display = isActive ? 'block' : 'none';
    }

    closeAllDropdowns() {
        this.dropdownTargets.forEach(dropdown => {
            dropdown.style.display = 'none';
            dropdown.classList.remove('active');
            dropdown.closest('.navigation__container-list-item')
                .querySelector('svg')
                .classList.remove('rotate-down-effects');
        });
    }

    redirect(event) {
        const { url, urlAnchor } = event.currentTarget.dataset;

        if (url) {
            this.close();
            setTimeout(() => this.handleRedirect(url, urlAnchor), 250);
        }
    }

    handleRedirect(url, anchor) {
        if (anchor) localStorage.setItem('anchor', anchor);
        window.location.href = url;
    }

    handleScrollToAnchor() {
        const anchor = localStorage.getItem('anchor');
        if (anchor) {
            localStorage.removeItem('anchor');
            setTimeout(() => this.scrollToAnchor(anchor), 100);
        }
    }

    scrollToAnchor(anchor) {
        const targetElement = document.querySelector(`#${anchor}`);
        if (targetElement) {
            const headerHeight = document.querySelector('.header')?.offsetHeight || 0;
            const targetPosition = targetElement.getBoundingClientRect().top +
                window.scrollY -
                headerHeight +
                this.headerHeightValue;

            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
        }
    }

    handleOutsideClick(event) {
        if ((this.mainContent.contains(event.target) ||
                this.overlayTarget.contains(event.target)) &&
            this.menuTarget.style.width !== '0%') {
            this.close();
        }
    }

    handleWindowResize() {
        if (this.menuTarget.style.width !== '0%') {
            this.close();
        }
    }
}