<template>
    <transition name="modal-fade" mode="out-in">
        <div :id="id" class="modal modal-dialog">
            <div v-if="!!title" class="modal-header" :class="{ fixedHeader: fixedHeader }">{{ title }}</div>
            <div class="modal-body">
                <slot name="body"></slot>
            </div>
            <div class="modal-footer" :class="{ fixedFooter: fixedFooter }">
                <div class="modal-button-container">
                    <div class="modal-cancel-button-wrapper">
                        <modal-button :class="buttons.cancel.className" @click="cancelClick($event)">
                            {{ buttons.cancel.caption }}
                        </modal-button>
                    </div>
                    <div class="modal-confirm-button-wrapper">
                        <modal-button :class="buttons.confirm.className" @click="confirmClick($event)">
                            {{ buttons.confirm.caption }}
                        </modal-button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import Button from './Button.vue';
    import SelectionItem from './GridItem.vue';

    export default {
        data: function () {
            return {
                buttons: {
                    cancel: {
                        className: this.buttons.cancel.class || "modal-cancel-button",
                        caption: this.buttons.cancel.caption || "Отмена"
                    },
                    confirm: {
                        className: this.buttons.confirm.class || "modal-confirm-button",
                        caption: this.buttons.confirm.caption || "Добавить"
                    }
                }
            }
        },

        props: {
            fixedHeader: {
                type: Boolean,
                default: true
            },
            fixedFooter: {
                type: Boolean,
                default: true
            },
            title: {
                type: String
            },
            buttons: {
                type: Object,
                required: false
            }
        },

        methods: {
            cancelClick: function (e) {
                this.$emit('сancelClick', e);
            },
            confirmClick: function (e) {
                this.$emit('сonfirmClick', e);
            }
        },

        components: {
            'modal-button': Button,
            'selection-item': SelectionItem
        }
    }
</script>

<style scoped>
    .modal-button-container {
        display: flex;
    }
    .modal-fade-enter-active, .modal-fade-leave-active {
        transition: opacity .3s ease;
    }
    .modal-fade-enter, .modL-fade-leave-to {
        opacity: 0;
    }
</style>