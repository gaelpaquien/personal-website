import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["frenchButton", "englishButton"]
    static values = {
        defaultLanguage: { type: String, default: 'fr' }
    }

    connect() {
        if (window.languageControllerInitialized) {
            this.applyLanguage();
            return;
        }

        window.languageControllerInitialized = true;

        this.syncLanguageState();
        this.applyLanguage();

        document.addEventListener('turbo:render', () => {
            this.syncLanguageState();
            this.applyLanguage();
        });
    }

    disconnect() {
        if (document.querySelectorAll('[data-controller*="language"]').length === 0) {
            window.languageControllerInitialized = false;
        }
    }

    toggleLanguage(event) {
        const language = event.currentTarget.dataset.language;
        const currentLanguage = this.getCurrentLanguage();

        if (language === currentLanguage) {
            return;
        }

        this.updateState(language);
    }

    syncLanguageState() {
        const urlLanguage = this.getLanguageFromURL();

        if (document.documentElement.lang !== urlLanguage) {
            document.documentElement.lang = urlLanguage;
            localStorage.setItem('language', urlLanguage);
        }
    }

    updateState(language) {
        document.documentElement.lang = language;
        localStorage.setItem('language', language);
        this.updateButtonState(language);
    }

    getLanguageFromURL() {
        return window.location.pathname.startsWith('/fr') ? 'fr' :
            window.location.pathname.startsWith('/en') ? 'en' : 'fr';
    }

    getCurrentLanguage() {
        return this.getLanguageFromURL();
    }

    applyLanguage() {
        const currentLanguage = this.getCurrentLanguage();
        this.updateButtonState(currentLanguage);
    }

    updateButtonState(language) {
        setTimeout(() => {
            const frenchButtons = document.querySelectorAll('[data-language-target="frenchButton"]');
            const englishButtons = document.querySelectorAll('[data-language-target="englishButton"]');

            [...frenchButtons, ...englishButtons].forEach(button => {
                button.classList.remove('inactive', 'active');
            });

            if (language === 'fr') {
                frenchButtons.forEach(button => button.classList.add('inactive'));
                englishButtons.forEach(button => button.classList.remove('inactive'));
            } else {
                englishButtons.forEach(button => button.classList.add('inactive'));
                frenchButtons.forEach(button => button.classList.remove('inactive'));
            }
        }, 0);
    }
}