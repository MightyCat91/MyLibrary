<template>
    <button :id="id" class="button" :class=" classes" :disabled="disabled" @click="onClick($event)">
        <slot>Отправить</slot>
    </button>
</template>

<script>
    export default {
        props: {
            id:  String,
            disabled: {
                type: Boolean,
                required: false
            },
            classes: String
        },

        methods: {
            onClick: function(e) {
                this.$emit('сlick', e);
            }
        }
    }
</script>

<style lang='css' scoped>
    .button {
        color: #009926;
        background-color: transparent;
        min-width: 64px;
        width: 100%;
        height: 2rem;
        border: 1px solid #009926;
        border-radius: 18px;
        outline: 0;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        margin-bottom: 30px;
        cursor: pointer;
        box-shadow: 0px 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    }

    .button:hover, .button:focus, .button:active {
        box-shadow: 0 1px 0 .5px rgba(0, 153, 38, .5) !important;
    }
</style>