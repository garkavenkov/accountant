<template>
    <div class="form-group">
        <label>{{caption}}</label>
        <input  type="date" 
                :name="name" 
                :id="id" 
                :value="value"
                class="form-control datetimepicker-input"
                v-bind:class="{'is-invalid' : error.length > 0}"
                @input="$emit('input', $event.target.value)">
        <span   :id="error_field_id" 
                class="error invalid-feedback">
                    {{error[0]}}
        </span>
    </div>
</template>

<script>
export default {
    props: {
        caption: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            required: true
        },
        error: {
            type: Array,
            default: () => [], 
            required: false
        }
    },
    data() {
        return {}
    },
    computed: {
        name() {
            return this.id
        },
        error_field_id() {
            return `${this.id}-error`;
        }
    }
}
</script>