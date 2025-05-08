class TestKlaviyoEventCreate extends HTMLElement
{
    // observed attributes will trigger the attributeChangedCallback
    static observedAttributes = ['event-name'];

    constructor() {
        super();

        this.attachShadow({mode: 'open'});

        this.shadowRoot.innerHTML = `
            <div class="digital-nature-admin-wrap">
                <link rel="stylesheet" href="` + this.dataset.stylesheet + `" media="all">
                <input type="text" name="event-name" value="A test event" id="klaviyo-event-create-test-event-name" />
                <button id="klaviyo-event-create-test-submit" type="submit">Test</button>
            </div>`

        const btn = this.shadowRoot.getElementById('klaviyo-event-create-test-submit');
        const eventNameInput = this.shadowRoot.getElementById('klaviyo-event-create-test-event-name');

        btn.addEventListener('click', () => {
            this.setAttribute('event-name', eventNameInput.value);
        })
    }

    attributeChangedCallback(name, oldValue, newValue)
    {
        if (oldValue === newValue) {
            return;
        }

        console.log('an attribute changed', name, oldValue, newValue);
        return;
        /**
        const btn = this.#root.children[0];
        btn.textContent = `Count: ${this.count}`;

        this.dispatchEvent(new CustomEvent('change', {detail: this.count}))
            */
    }
}

// add the custom element to the registry
customElements.define('tools-for-klaviyo-test-event-create', TestKlaviyoEventCreate);