class TestKlaviyoEventCreate extends HTMLElement
{
    // observed attributes will trigger the attributeChangedCallback
    static observedAttributes = ['event-name'];

    constructor() {
        super();

        // get the template and attach shadow dom with that content
        const template = document.getElementById('digital-nature-admin-test-event-create-template').content;
        this.attachShadow({ mode: 'open' }).appendChild(template.cloneNode(true));

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
        let loadingMessage = 'Sending data, please wait...';

        let loadingOverlay = document.createElement('digital-nature-loading-overlay');
        this.shadowRoot.appendChild(loadingOverlay);
        loadingOverlay.addMessage(loadingMessage);

        let response = await window.DigitalNature.utils.request.post(
            `/wp-json/tools-for-klaviyo/v1/events`,
            {
                event: this.getAttribute('event-name'),
                "event-data": {
                    'send': 'success'
                }
            }
        );

        loadingOverlay.deleteMessage(loadingMessage);

        let responseMessage = document.createElement('digital-nature-dismissable-message');
        responseMessage.setContent('Hoo ha! Your event was sent successfully!', 'success');
        this.shadowRoot.appendChild(responseMessage);

        console.log(response);
    }
}

// add the custom element to the registry
customElements.define('tools-for-klaviyo-test-event-create', TestKlaviyoEventCreate);