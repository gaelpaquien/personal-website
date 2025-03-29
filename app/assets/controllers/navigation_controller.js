import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["overlay", "menu", "openButton", "closeButton", "dropdown", "arrow", "menuContent"]
    static values = {
        transitionDuration: { type: Number, default: 250 },
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

        this.menuTarget.style.overflowX = 'hidden';

        if (this.hasMenuContentTarget) {
            this.menuContentTarget.style.transform = 'translateX(0)';
            this.menuContentTarget.style.width = '100%';
        }
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
    }

    close() {
        this.toggleMenu(false);
    }

    toggleMenu(isOpen) {
        const breakpoint = this.getCurrentBreakpoint();

        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
        this.overlayTarget.style.display = isOpen ? 'block' : 'none';
        this.overlayTarget.style.top = isOpen ? '0' : '';
        this.overlayTarget.style.height = isOpen ? '100vh' : '';

        if (isOpen) {
            if (this.hasMenuContentTarget) {
                this.menuContentTarget.style.transition = 'none';
                this.menuContentTarget.style.transform = 'translateX(0)';
            }

            this.menuTarget.style.top = '0';
            this.menuTarget.style.paddingTop = '2.5rem';
            this.menuTarget.style.borderLeft = 'solid 0.1rem var(--color-text)';
            this.menuTarget.style.width = `${breakpoint.menuWidth}%`;

            if (window.innerWidth >= 768) {
                setTimeout(() => {
                    this.mainContent.style.width = `${100 - breakpoint.menuWidth}%`;
                }, 300);
            }
        } else {
            this.menuTarget.style.borderLeft = 'none';
            this.mainContent.style.width = '100%';

            if (this.hasMenuContentTarget) {
                this.menuContentTarget.style.transition = `transform ${this.transitionDurationValue}ms`;
                this.menuContentTarget.style.transform = 'translateX(100%)';
            }

            setTimeout(() => {
                this.menuTarget.style.width = '0%';
            }, 5);
        }
    }

    getCurrentBreakpoint() {
        const { desktop, tablet, mobile } = this.breakpointsValue;
        if (window.innerWidth >= desktop.width) return desktop;
        if (window.innerWidth >= tablet.width) return tablet;
        return mobile;
    }

    toggleDropdown(event) {
        const dropdown = event.currentTarget.closest('.navigation__dropdown');
        const content = dropdown.querySelector('.navigation__dropdown-content');
        const arrow = dropdown.querySelector('svg');
        const isActive = !content.classList.contains('active');

        this.closeAllDropdowns();

        content.classList.toggle('active', isActive);
        arrow.classList.toggle('rotate-down-effects', isActive);
    }

    closeAllDropdowns() {
        this.dropdownTargets.forEach(dropdown => {
            dropdown.classList.remove('active');
            const parentDropdown = dropdown.closest('.navigation__dropdown');
            if (parentDropdown) {
                const arrow = parentDropdown.querySelector('svg');
                if (arrow) arrow.classList.remove('rotate-down-effects');
            }
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