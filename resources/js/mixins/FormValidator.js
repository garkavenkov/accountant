export default {
    data() {
        return {
            errors: {}
        }
    },
    methods: {
        getError(field) {
            if (this.errors && this.errors[field]) {
                return this.errors[field][0];
            }
            return '';
        },
        hasError(field) {
            if (this.errors && this.errors[field]) {
                return true;
            }
            return false;
        },
    },
}