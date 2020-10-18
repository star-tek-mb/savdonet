<template>
  <div class="card">
    <img
      :src="'/storage/' + product.variations[0].photo_url"
      class="card-img-top"
      :alt="__(product.title)"
    />
    <div class="card-body">
      <p class="h5 card-title">
        {{ __(product.title) }}
        <template v-if="get_sale_price(product)">
          <del v-if="get_price(product)[0] == get_price(product)[1]" class="text-danger float-right">{{ get_price(product)[0] }} {{ __('currency') }}</del>
          <del v-if="get_price(product)[0] != get_price(product)[1]" class="text-danger float-right">{{ get_price(product)[0] }} - {{ get_price(product)[1] }}  {{ __('currency') }}</del>
          <br>
          <span v-if="get_sale_price(product)[0] == get_sale_price(product)[1]" class="text-danger float-right">{{ get_sale_price(product)[0] }} {{ __('currency') }}</span>
          <span v-else-if="get_sale_price(product)[0] != get_sale_price(product)[1]" class="text-danger float-right">{{ get_sale_price(product)[0] }} - {{ get_sale_price(product)[1] }}  {{ __('currency') }}</span>
        </template>
        <template v-else>
          <span v-if="get_price(product)[0] == get_price(product)[1]" class="text-danger float-right">{{ get_price(product)[0] }} {{ __('currency') }}</span>
          <span v-if="get_price(product)[0] != get_price(product)[1]" class="text-danger float-right">{{ get_price(product)[0] }} - {{ get_price(product)[1] }}  {{ __('currency') }}</span>
        </template>
      </p>
      <p>{{ __(product.description) | strip | trunc(200) }}</p>
    </div>
    <div class="mb-4 mr-4 text-right">
      <a v-if="product.options.length == 0" class="btn btn-primary" :href="'/' + documentLanguage + '/cart/' + product.variations[0].id">{{ __("To Cart") }}</a>
      <a class="btn btn-info" :href="'/' + documentLanguage + '/product/' + product.id">{{ __("More") }}</a>
    </div>
  </div>
</template>
<script>
export default {
  props: ["product"],
  methods: {
    get_date: function(date) {
      var dateParts = date.split("-");
      return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
    },
    get_price: function(product) {
      var min = 999999999;
      var max = 0;
      for (let i = 0; i < product.variations.length; i++) {
        var p = product.variations[i];
        var price = p.price;
        if (price < min) {
          min = price;
        }
        if (price > max) {
          max = price;
        }
      }
      return [min, max];
    },
    get_sale_price: function(product) {
      var min = 999999999;
      var max = 0;
      for (let i = 0; i < product.variations.length; i++) {
        var p = product.variations[i];
        var price = p.sale_price;
        if (!p.sale_price)
          return null;
        var sale_start = this.get_date(product.variations[i].sale_start).getTime();
        var sale_end = this.get_date(product.variations[i].sale_end).getTime();
        var now = Date.now();
        if (sale_start > now || now > sale_end) {
          return null;
        }
        if (price < min) {
          min = price;
        }
        if (price > max) {
          max = price;
        }
      }
      return [min, max];
    }
  }
};
</script>