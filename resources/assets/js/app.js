/**
 * Сначала мы загрузим все JavaScript-зависимости этого проекта,
 * включая Vue и Vue Resource. Это отличная отправная точка для
 * создания надёжных, мощных веб-приложений с помощью Vue и Laravel.
 */

// require('./bootstrap');
import Vue from '../../../node_modules/vue/dist/vue.esm.js';
import Button from './components/Button.vue';
import Input from './components/Input.vue';
import Selection from './components/SelectionAdd.vue';
import 'vue-awesome/icons';
import Icon from 'vue-awesome/components/Icon.vue'


Vue.component('Vue', Vue);
Vue.component('icon', Icon);



/**
 * Затем мы создадим новый экземпляр Vue-приложения и прикрепим его
 * к странице. Затем вы можете начать добавлять компоненты в это приложение
 * или настроить заготовки JavaScript под ваши конкретные нужды.
 */
new Vue({
    el: "#selections-container",
    components: {
        'v-button': Button,
        'v-input': Input,
        'v-selection-add': Selection
    }
});