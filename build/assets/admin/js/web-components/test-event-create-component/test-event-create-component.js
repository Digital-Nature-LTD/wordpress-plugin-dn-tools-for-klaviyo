import DigitalNatureWebComponent from "@digital-nature-ltd/web-component";
import DigitalNatureLoadingOverlayComponent from "@digital-nature-ltd/loading-overlay-component";
import DigitalNatureDismissableMessageComponent from "@digital-nature-ltd/dismissable-message-component";
import template from "./test-event-create-component-template.html?raw"

class TestKlaviyoEventCreate extends DigitalNatureWebComponent
{
    static tagName = 'tools-for-klaviyo-test-event-create';
    // observed attributes will trigger the attributeChangedCallback
    static observedAttributes = ['event-name'];

    constructor() {
        super({
            template: template,
        });

        // assign elements to vars
        const btn = this.shadowRoot.getElementById('klaviyo-event-create-test-submit');
        const eventNameInput = this.shadowRoot.getElementById('klaviyo-event-create-test-event-name');

        // add listeners
        btn.addEventListener('click', () => {
            this.setAttribute('event-name', eventNameInput.value);
            this.runTest().then(r => {});
        })
    }

    async runTest()
    {
        let loadingMessages = [
            'Sending data, please wait...',
            'Processing your request...',
        ]

        let loadingOverlay = DigitalNatureLoadingOverlayComponent.create();
        // remove all DigitalNatureLoadingOverlayComponent from this.shadowRoot
        this.shadowRoot.querySelectorAll(DigitalNatureLoadingOverlayComponent.tagName).forEach(el => el.remove());
        // add the new loading overlay
        this.shadowRoot.appendChild(loadingOverlay);
        // add messages to the loading overlay
        loadingMessages.forEach(message => loadingOverlay.addMessage(message));

        let response = await window.DigitalNature.utils.request.post(
            `/wp-json/tools-for-klaviyo/v1/events`,
            {
                event: this.getAttribute('event-name'),
                "event-data": {
                    'send': 'success'
                }
            }
        );

        loadingMessages.forEach(message => loadingOverlay.deleteMessage(message));

        let responseMessage = DigitalNatureDismissableMessageComponent.create({
            'message': 'Success! Your event was sent to Klaviyo!',
            'classes': ['success']
        });
        this.shadowRoot.appendChild(responseMessage);
    }
}

// add the custom element to the registry
customElements.define(TestKlaviyoEventCreate.tagName, TestKlaviyoEventCreate);