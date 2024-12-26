import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        url: String // URL value for redirection
    }

    redirectToUrl() {
        // Redirect to the specified URL if the value exists
        if (this.urlValue) {
            window.location.href = this.urlValue;
        } else {
            // Log an error if the URL value is missing
            console.error('URL value is missing.');
        }
    }
}
