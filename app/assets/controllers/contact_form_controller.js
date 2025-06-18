import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["form", "submit"]
    static values = {
        sending: String,
        error: String,
        validationError: String
    }

    async submitForm(event) {
        event.preventDefault()

        const formData = new FormData(this.formTarget)

        const inputFileController = this.element.querySelector('[data-controller*="input-file"]')
        if (inputFileController) {
            const controller = this.application.getControllerForElementAndIdentifier(inputFileController, 'input-file')
            if (controller) {
                formData.delete('contact[attachment][]')
                Array.from(controller.getFiles()).forEach(file => {
                    formData.append('contact[attachment][]', file)
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
                const inputFileController = this.element.querySelector('[data-controller*="input-file"]')
                if (inputFileController) {
                    const controller = this.application.getControllerForElementAndIdentifier(inputFileController, 'input-file')
                    if (controller) {
                        controller.reset()
                    }
                }
            } else {
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
            submitBtn.disabled = false
            submitBtn.textContent = originalText
        }
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