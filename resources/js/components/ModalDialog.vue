<template>
    <div class="modal fade" :id="modalId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ title }}</h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="closeModal"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <slot></slot>
                </div>

                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        @click="closeModal"
                    >
                        Close
                    </button>
                    <slot name="buttons"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalDialog",
    props: ["modalId", "title"],
    data() {
        return {};
    },
    methods: {
        closeModal() {
            this.$emit("close");
        }
    }
};
</script>
