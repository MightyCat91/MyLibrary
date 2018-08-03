<template>
    <div class="button-close" @click="onClick($event)">
        <icon name="minus-circle"></icon>
    </div>
</template>

<script>
    export default {
        methods: {
            onClick: function(e) {
                this.$emit('click', e);
            }
        }
    }
</script>

<style scoped>
    .button-close {
        text-align: right;
        margin-left: 1rem;
        opacity: 0.7;
        transition: 0.5s;
        font-size: 20px;
        cursor: pointer;
        margin-bottom: 5px;
    }

    .button-close:hover {
        opacity: 1;
        color: #ce2e2e;
    }
</style>