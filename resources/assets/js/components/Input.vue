<template>
    <div class="form-input-wrapper" :class="{ error: hasError }">
        <div v-for="(input, key) in inputs">
            <div class="input-container">
                <textarea v-if="isTextarea" :rows="rows" :id="id" :name="multiple ? name+'['+ key +']' : name"
                          class="form-input" :value="input.value" :maxlength="maxlength" @focus="input.isActive = true"
                          @blur="focusOut($event, key)" @input="inputChange($event, key)" v-focus-on-create></textarea>
                <input v-else :id="id" :name="multiple ? name+'['+ key +']' : name"
                       class="form-input" :value="input.value" :maxlength="maxlength" @focus="input.isActive = true"
                       @blur="focusOut($event, key)" @input="inputChange($event, key)" v-focus-on-create>
                <label class="input-label" :class="{ active: input.isActive }"
                       @click="$event.target.previousElementSibling.focus()">
                    <slot>{{ title }}</slot>
                </label>
                <clone-button v-if="multiple && input.count === count" @click="cloneInput($event, key)"
                              :class="{error: input.cloneError}"></clone-button>
                <close-button v-else-if="multiple" @click="deleteClonedInput($event, key)"></close-button>
            </div>
        </div>
        <div v-if="hasError" class="form-input-error-message">
            <p>{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
    import CloseButton from './CloseButton.vue';
    import CloneInputButton from './CloneInputButton.vue';
    import Vue from './../../../../node_modules/vue/dist/vue.esm.js';

    Vue.directive('focus-on-create', {
        inserted: function (el) {
            Vue.nextTick(function() {
                el.focus()
            })
        }
    });

    export default {
        data: function () {
            return {
                isTextarea: false,
                count: 0,
                hasError: false,
                input: {
                    value: '',
                    isActive: false,
                    cloneError: false,
                    count: 0,
                },
                inputs: [{
                    value: this.value,
                    isActive: !!this.value,
                    cloneError: false,
                    count: 0,
                }]
            }
        },

        props: {
            id: {
                type: String,
                required: false
            },
            name: {
                type: String,
                required: true
            },
            value: {
                type: String,
                required: false
            },
            maxlength: {
                type: String,
                default: "1024"
            },
            errorMessage: {
                type: String
            },
            multiple: {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                required: true
            },
            rows: {
                type: String,
            }
        },

        created: function () {
            this.inputs.isActive = !!this.value;
            this.inputs.count = this.count;
            this.hasError = !!this.errorMessage;
            this.isTextarea = !!this.rows;
        },

        methods: {
            focusOut: function (e, key) {
                this.inputs[key].isActive = !!e.target.value;
            },
            inputChange: function (e, key) {
                e.target.parentElement.classList.remove("error");
                this.hasError = false;
                this.inputs[key].value = e.target.value;
                this.inputs[key].cloneError = false;
            },
            cloneInput: function (e, key) {
                let inputValue = e.path.filter(val => val.className === 'input-container')[0].firstChild.value;
                if (!!inputValue) {
                    this.inputs.push(Vue.util.extend({}, this.input));
                    this.count += 1;
                    this.inputs[++key].count = this.count;
                } else {
                    this.inputs[key].cloneError = true;
                }
            },
            deleteClonedInput: function (e, key) {
                this.inputs.splice(key, 1);
            }
        },

        components: {
            'close-button': CloseButton,
            'clone-button': CloneInputButton,
        }
    };
</script>

<style lang='css' scoped>
    .form-input-wrapper {
        position: relative;
        margin-bottom: 30px;
    }

    .input-container {
        display: inline-flex;
        position: relative;
        align-items: flex-end;
        width: 100%;
        margin-bottom: 1rem;
    }

    .form-input {
        border: 0;
        border-bottom: 1px solid #9e9e9e;
        border-radius: 0;
        margin-bottom: 5px;
        outline: none;
        background-color: transparent;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }

    .form-input:active, .form-input:focus {
        border-bottom: 1px solid #009926;
        box-shadow: 0 1px 0 0 #009926;
        transition: 0.5s;
    }

    .input-label {
        position: absolute;
        font-size: 1rem;
        cursor: text;
        margin: 0;
        transition: 0.3s;
        color: #9e9e9e;
        top: 0.6rem;
    }

    .input-label.active {
        position: absolute;
        transform: translateY(-135%);
        font-size: 0.8rem;
        transition: 0.3s;
        opacity: 1;
        color: #009926;
    }

    .form-input-wrapper.error > .form-input-error-message, .form-input-wrapper.error > .form-input:focus + .input-label {
        color: #ce2e2e;
    }

    .form-input-wrapper.error > .form-input {
        border-color: #ce2e2e;
    }

    .form-input-wrapper.error > .form-input:focus {
        box-shadow: 0 1px 0 0 #ce2e2e;
    }

    .form-input-error-message {
        font-size: 12px;
    }
</style>