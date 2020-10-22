require('./bootstrap_app');

import Vue from 'vue';
import ProductChooser from './vue/product-chooser.vue';

window.loaded_lang = {};
Vue.prototype.documentLanguage = document.documentElement.lang;
Vue.prototype.__ = function (str) {
  if (str[document.documentElement.lang]) {
    return str[document.documentElement.lang];
  }
  return window.loaded_lang[str] || str;
};
Vue.filter('currency', function (value) {
  return parseInt(value).toLocaleString('ru', { maximumFractionDigits: 0 });
});

(async function () {
  var res = await axios.get('/lang/' + document.documentElement.lang + '.json');
  window.loaded_lang = res.data;

  new Vue({
    render: h => h(ProductChooser, {
      props: {
        id: window.product_id
      }
    })
  }).$mount('#product-chooser');

})();
