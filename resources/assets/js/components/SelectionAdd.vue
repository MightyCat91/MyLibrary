<template>
    <div>
        <div id="books-in-selection-container">
            <div v-for="(item, key) in books">
                <selection-item></selection-item>
            </div>
        </div>
        <modal-dialog :class="{open: modalIsOpen}" @сancelClick="сancelClick($event)" @сonfirmClick="сonfirmClick($event)">
            <slot slot="body">
                <h1>Test</h1>
            </slot>
        </modal-dialog>
        <add-files-button @click="addFiles($event)">Добавить книги в подборку</add-files-button>
    </div>
</template>

<script>
    import Button from './Button.vue';
    import SelectionItem from './GridItem.vue';
    import ModalDialog from './Modal.vue';

    export default {
        data: function () {
            return {
                modalIsOpen: false,
                books: {

                }
            }
        },
        methods: {
            addFiles: function(e) {
                this.modalIsOpen = true;
            },
            сonfirmClick: function (e) {
                this.modalIsOpen = false
            },
            сancelClick: function (e) {
                this.modalIsOpen = false
            }
        },

        components: {
            'add-files-button': Button,
            'selection-item': SelectionItem,
            'modal-dialog': ModalDialog
        }
    }
</script>

<style scoped>
</style>