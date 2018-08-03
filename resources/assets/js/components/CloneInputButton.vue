<template>
    <div class="button-clone" @click="onClick($event)">
        <icon name="plus-circle"></icon>
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
    .button-clone {
        text-align: right;
        margin-left: 1rem;
        opacity: 0.7;
        transition: 0.5s;
        font-size: 20px;
        cursor: pointer;
        margin-bottom: 5px;
    }

    .button-clone:hover {
        opacity: 1;
        color: #009926;
    }

    .button-clone.error {
        color: #ce2e2e;
        transition: 0.2s;
        transform: rotate(45deg);
    }
</style>