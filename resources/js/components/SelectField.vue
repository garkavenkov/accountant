<template>
    <div class="form-group">
        <label>{{caption}}</label>
        <select class="form-control select2" 
                style="width: 100%;" 
                :id="id"
                @change="changed(parseInt($event.target.value))"
                v-bind:class="{'is-invalid' : error.length > 0}">
            <option 
                    :selected="value == 0"
                    :disabled="disabledHint"
                    value="0"
                    v-if="hint.length > 0">
                {{hint}}
            </option>
            <option v-for="option in options" 
                    :selected="option[field] == value"
                    :value="option[field]" 
                    :key="option[field]">
                        {{option[name]}}
            </option>                          
        </select>
        <span   id="supplier-error" 
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
            },
            error: {
                type: Array,
                default: () => [], 
                required: false
            },
            hint: {
                type: String,
                default: '',
                required: false
            },
            disabledHint: {
                type: Boolean,
                default: true,
                required: false
            },
            options: {
                type: Array,
                required: true
            },
            value: {
                type: Number,
                required: true
            },
            name: {
                type: String,
                required: false,
                default: 'name'
            },
            id: {
              type: String,
              required: true,
            },
            field: {
                type: String,
                required: false,
                default: 'id'
            },            
        },
        data() {
            return {

            }
        },
        methods: {
            changed(value) {
                this.$emit('input', value)
            }
        },
        created() {
            // console.log(this.errors);
        }
    }
</script>