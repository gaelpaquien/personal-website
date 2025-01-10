import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        url: String,
        delay: { type: Number, default: 0 }
    }

    connect() {
        if (!this.hasUrlValue) {
            console.warn('No URL provided for redirect controller');
        }
    }

    redirectToUrl() {
        if (!this.hasUrlValue) return;

        if (this.delayValue) {
            setTimeout(() => {
                this.performRedirect();
            }, this.delayValue);
        } else {
            this.performRedirect();
        }
    }

    performRedirect() {
        try {
            window.location.href = this.urlValue;
        } catch (error) {
            console.error('Failed to redirect:', error);
        }
    }
}