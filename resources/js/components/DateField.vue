<template>
    <div class="form-group">
        <label>{{label}}</label>
        <input  type="date" 
                :name="name" 
                :id="id" 
                :value="value && value.toISOString().slice(0,10)"
                class="form-control datetimepicker-input"
                v-bind:class="{'is-invalid' : error.length > 0}"
                @input="$emit('input', $event.targer.value)">
        <span   :id="error_field_id" 
                class="error invalid-feedback">
                    {{error[0]}}
        </span>
    </div>
</template>

<script>
export default {
    props: {
        label: {
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