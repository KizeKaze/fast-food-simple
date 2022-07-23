//javascript module, a file that can export things to the outside world.
//in this case we are exporting an object
export default {
    template:
        `
            <button 
                :class="{
                    'border rounded px-5 py-2 disabled:cursor-not-allowed': true,
                    'bg-gray-200 hover:gb-gray-400': type === 'muted',
                    'bg-blue-600 hover:gb-gray-400': type === 'primary',
                    'bg-red-200 hover:gb-gray-400': type === 'secondary',
                    'is-loading': processing
                }" 
                :disabled="processing"
                >
                    <slot />
            </button>
        `,

    props: {
        type: {
            type: String,
            default: 'primary'
        },
        processing: {
            type: Boolean,
            default: false
        }
    }
}