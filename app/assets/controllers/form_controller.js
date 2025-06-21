import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["form", "submit"]
    static values = {
        sending: String,
        error: String,
        validationError: String,
        successRedirect: { type: String, default: "" },
        rateLimited: { type: Boolean, default: false },
        retryAfter: { type: Number, default: 0 },
        blockedText: { type: String, default: "" }
    }

    connect() {
        if (this.rateLimitedValue && this.retryAfterValue > 0) {
            this.disableFormTemporarily(this.retryAfterValue)
        }
    }

    async submitForm(event) {
        event.preventDefault()

        const formData = new FormData(this.formTarget)

        const inputFileController = this.element.querySelector('[data-controller*="input-file"]')
        if (inputFileController) {
            const controller = this.application.getControllerForElementAndIdentifier(inputFileController, 'input-file')
            if (controller) {
                const fieldName = this.formTarget.querySelector('input[type="file"]').name
                formData.delete(fieldName)
                Array.from(controller.getFiles()).forEach(file => {
                    formData.append(fieldName, file)
                })
            }
        }

        const submitBtn = this.submitTarget
        const originalText = submitBtn.textContent

        submitBtn.disabled = true
        submitBtn.textContent = this.sendingValue

        this.clearErrors()

        try {
            const response = await fetch(this.formTarget.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })

            const data = await response.json()

            if (data.success) {
                window.Toast.success(data.message)
                this.formTarget.reset()

                if (inputFileController) {
                    const controller = this.application.getControllerForElementAndIdentifier(inputFileController, 'input-file')
                    if (controller) {
                        controller.reset()
                    }
                }

                if (this.successRedirectValue) {
                    setTimeout(() => {
                        window.location.href = this.successRedirectValue
                    }, 2000)
                }
            } else {
                if (data.rate_limited) {
                    window.Toast.error(data.message)
                    this.disableFormTemporarily(300)
                    return
                }

                if (data.errors) {
                    this.showErrors(data.errors)
                    window.Toast.error(this.validationErrorValue)
                }
                if (data.message) {
                    window.Toast.error(data.message)
                }
            }
        } catch (error) {
            window.Toast.error(this.errorValue)
        } finally {
            if (!this.submitTarget.classList.contains('rate-limited')) {
                submitBtn.disabled = false
                submitBtn.textContent = originalText
            }
        }
    }

    disableFormTemporarily(seconds) {
        const submitBtn = this.submitTarget
        submitBtn.classList.add('rate-limited', 'disabled')
        submitBtn.disabled = true

        let countdown = Math.max(1, seconds)
        const originalText = submitBtn.dataset.originalText || submitBtn.textContent

        if (!submitBtn.dataset.originalText) {
            submitBtn.dataset.originalText = submitBtn.textContent
        }

        const updateButtonText = () => {
            const minutes = Math.floor(countdown / 60)
            const secs = countdown % 60
            submitBtn.textContent = `${this.blockedTextValue} ${minutes}:${secs.toString().padStart(2, '0')}`
        }

        updateButtonText()

        const interval = setInterval(() => {
            countdown--
            updateButtonText()

            if (countdown <= 0) {
                clearInterval(interval)
                submitBtn.disabled = false
                submitBtn.textContent = originalText
                submitBtn.classList.remove('rate-limited', 'disabled')
                delete submitBtn.dataset.originalText
            }
        }, 1000)
    }

    showErrors(errors) {
        Object.keys(errors).forEach(field => {
            let input = this.formTarget.querySelector(`[name*="${field}"]`)

            if (field === 'attachment') {
                const fileContainer = this.formTarget.querySelector('[data-controller*="input-file"]')
                if (fileContainer) {
                    const errorDiv = document.createElement('div')
                    errorDiv.className = 'form-error'
                    errorDiv.textContent = errors[field][0]
                    fileContainer.appendChild(errorDiv)
                    fileContainer.classList.add('form-field-error')
                }
            } else if (input) {
                const errorDiv = document.createElement('div')
                errorDiv.className = 'form-error'
                errorDiv.textContent = errors[field][0]
                input.parentNode.appendChild(errorDiv)
                input.classList.add('form-field-error')
            }
        })
    }

    clearErrors() {
        this.formTarget.querySelectorAll('.form-error').forEach(el => el.remove())
        this.formTarget.querySelectorAll('.form-field-error').forEach(el => el.classList.remove('form-field-error'))
    }
}