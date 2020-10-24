require('./bootstrap_app');

import Vue from 'vue';
import Home from './vue/home.vue';
import InfiniteLoading from 'vue-infinite-loading';

window.loaded_lang = {};
Vue.prototype.documentLanguage = document.documentElement.lang;
Vue.prototype.__ = function(str) {
  if (str[document.documentElement.lang]) {
      return str[document.documentElement.lang];
  }
  return window.loaded_lang[str] || str;
};
Vue.filter('currency', function (value) {
  return parseInt(value).toLocaleString('ru', {maximumFractionDigits: 0});
});

Vue.use(InfiniteLoading);
Vue.component('menu-component', require('./vue/menu-component.vue').default);
Vue.component('submenu-component', require('./vue/submenu-component.vue').default);
Vue.component('product-component', require('./vue/product-component.vue').default);

(async function () {
  var res = await axios.get('/lang/' + document.documentElement.lang + '.json');
  window.loaded_lang = res.data;

  new Vue({
    render: h => h(Home)
  }).$mount('#home');

})();
