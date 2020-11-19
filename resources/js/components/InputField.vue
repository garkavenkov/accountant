<template>
    <div class="form-group">
        <label>{{label}}</label>                                
        <input  type="text"         
                :name="field_name" 
                :id="id" 
                class="form-control"  
                :placeholder="placeholder"  
                :value="value"
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
        label: {
            type: String,
            required: false,
            default: ""
        },
        placeholder: {
            type: String,
            required: false,
            default: ''
        },
        value: [String, Number],
        error: {
            type: Array,
            default: () => [], 
            required: false
        },
        id: {
            type: String,
            required: true,
        },
    },
    date() {
        return {

        }
    },
    computed: {
        field_name() {
            return this.id;
        },
        error_field_id() {
            return `${this.id}-error`;
        }
    }
}
</script>