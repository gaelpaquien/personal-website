import { Controller } from '@hotwired/stimulus'

class Toast {
    static show(message, type = 'success') {
        const container = Toast.getOrCreateContainer()

        Toast.hideExistingToasts()

        const toast = Toast.createToast(message, type)
        container.appendChild(toast)

        requestAnimationFrame(() => {
            toast.classList.add('toast--show')
            Toast.startProgressBar(toast)
        })

        const timeoutId = setTimeout(() => Toast.hide(toast), 4000)
        toast.dataset.timeoutId = timeoutId
    }

    static success(message) {
        Toast.show(message, 'success')
    }

    static error(message) {
        Toast.show(message, 'error')
    }

    static hideExistingToasts() {
        const existingToasts = document.querySelectorAll('.toast.toast--show')
        existingToasts.forEach((toast, index) => {
            if (toast.dataset.timeoutId) {
                clearTimeout(parseInt(toast.dataset.timeoutId))
            }

            setTimeout(() => Toast.hide(toast), index * 100)
        })
    }

    static getOrCreateContainer() {
        let container = document.getElementById('toast-container')
        if (!container) {
            container = document.createElement('div')
            container.id = 'toast-container'
            container.className = 'toast-container'
            document.body.appendChild(container)
        }
        return container
    }

    static createToast(message, type) {
        const toast = document.createElement('div')
        toast.className = `toast toast--${type}`

        toast.innerHTML = `
            <span class="toast-message">${message}</span>
            <button class="toast-close">×</button>
            <div class="toast-progress"></div>
        `

        toast.querySelector('.toast-close').addEventListener('click', () => {
            if (toast.dataset.timeoutId) {
                clearTimeout(parseInt(toast.dataset.timeoutId))
            }
            Toast.hide(toast)
        })

        return toast
    }

    static startProgressBar(toast) {
        const progressBar = toast.querySelector('.toast-progress')
        progressBar.style.width = '100%'
        requestAnimationFrame(() => {
            progressBar.style.width = '0%'
        })
    }

    static hide(toast) {
        toast.classList.remove('toast--show')
        setTimeout(() => toast.remove(), 300)
    }
}

window.Toast = Toast

export default class extends Controller {}