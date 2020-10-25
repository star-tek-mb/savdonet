<template>
    <div v-if="info">
        <div v-for="option in info.product.options" :key="option" class="my-2">
            <h4>{{ __(get_option(option).title) }}</h4>
            <div class="btn-group btn-group-justified w-100">
                <button
                    v-for="value in get_available_values(option)"
                    :key="value.id"
                    @click="selected(option, value.id)"
                    class="btn btn-primary py-1 mx-1"
                    :class="{
                        'btn-danger': selected_values[option] == value.id,
                    }"
                    :disabled="check(value) == true"
                >
                    {{ __(value.title) }}
                </button>
            </div>
        </div>
        <div class="mt-4 text-left">
            <h4>{{ __("Make an Order") }}</h4>
            <div class="my-auto mx-2" v-if="selected_variant != null">
                <p class="h4">
                    <b>{{ __("Stock") }}</b
                    >: {{ selected_variant.stock }}
                </p>
                <p
                    class="h4 font-weight-bold"
                    v-if="
                        get_price(selected_variant)[0] ==
                        get_price(selected_variant)[1]
                    "
                >
                    <b>{{ __("Price") }}</b
                    >: {{ get_price(selected_variant)[0] | currency }}
                    {{ __("currency") }}
                </p>
                <p class="h4" v-else>
                    <b>{{ __("Price") }}</b
                    >:
                    <del
                        >{{ get_price(selected_variant)[0] | currency }}
                        {{ __("currency") }}</del
                    >
                    <span
                        >{{ get_price(selected_variant)[1] | currency }}
                        {{ __("currency") }}</span
                    >
                </p>
            </div>
            <div class="row">
                <div class="col-12 my-1">
                    <input
                        type="number"
                        class="form-control my-1"
                        v-model="quantity"
                    />
                </div>
                <div class="col-12 btn-group btn-group-justified w-100">
                    <button
                        class="btn btn-primary py-2 m-1"
                        @click="order"
                        :disabled="selected_variant == null"
                    >
                        {{ __("Order") }}
                    </button>
                    <button
                        class="btn btn-primary py-2 m-1"
                        @click="to_cart"
                        :disabled="selected_variant == null"
                    >
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["id"],
    data: function () {
        return {
            selected_values: {},
            selected_variant: null,
            disabled_variations: [],
            info: null,
            quantity: 1,
        };
    },
    methods: {
        get_option(id) {
            return this.info.options.find((element) => element.id == id);
        },
        is_in_same_option(a, b) {
            var el_a = this.info.values.find((element) => element.id.toString() == a.toString());
            var el_b = this.info.values.find((element) => element.id.toString() == b.toString());
            return el_a.option_id == el_b.option_id;
        },
        get_available_values(option_id) {
            var result = [];
            this.info.values.forEach((element) => {
                var in_product = this.info.product.variations.some(
                    (v) => v.values.indexOf(element.id.toString()) != -1
                );
                if (element.option_id == option_id && in_product) {
                    result.push(element);
                }
            });
            return result;
        },
        selected(option, value) {
            // if already selected - deselect
            if (this.selected_values[option] == value) {
                this.$set(this.selected_values, option, -1);
            } else {
                this.$set(this.selected_values, option, value);
            }
            // calc disabled
            this.calc_disabled();
            // check wheter all options checked
            var all_selected = Object.values(this.selected_values).every(
                (element) => parseInt(element) != -1
            );
            var sort_int = function (x, y) {
                return parseInt(x) - parseInt(y); // int sort for values, options
            };
            if (all_selected) {
                // find selected variant by values
                var b = Object.values(this.selected_values).sort(sort_int); // sorted match
                this.selected_variant = this.info.product.variations.find((element) => {
                    var a = element.values.sort(sort_int); // sorted match
                    return a.every((val, index) => val == b[index]);
                });
                // if found - change product photo and scroll into it
                if (this.selected_variant != null) {
                    $(".img-thumbnail").removeClass("active");
                    $("#variation-photo").attr("src", "/storage/" + this.selected_variant.photo_url);
                    document.getElementById("variation-photo").scrollIntoView({ behavior: "smooth" });
                }
            } else {
                this.selected_variant = null;
            }
        },
        get_primary_selection() {
            var primary_selection = [];
            Object.values(this.selected_values).forEach((element) => {
                if (element != -1) {
                    primary_selection.push(element);
                }
            });
            return primary_selection;
        },
        calc_disabled() {
            this.disabled_variations.splice(0);
            var primary_selection = this.get_primary_selection();
            if (primary_selection.length == 0) {
                return;
            }
            // disable variations that do not have primary selection in values
            this.info.product.variations.forEach((element) => {
                var disabled = false;
                for (var i = 0; i < primary_selection.length; i++) {
                    if (element.values.indexOf(primary_selection[i].toString()) == -1) {
                        disabled = true;
                        break;
                    }
                }
                if (disabled) {
                    this.disabled_variations.push(element);
                }
            });
        },
        check(val) {
            // enabled variations with val in variation.values
            let difference = this.info.product.variations.filter(
                (x) => !this.disabled_variations.includes(x)
            );
            // if one selection is active - enable sibling values
            var s = this.get_primary_selection();
            var pred = s.length == 1 && this.is_in_same_option(s[0], val.id);
            return (
                !pred && !difference.find((element) => element.values.indexOf(val.id.toString()) != -1
                ));
        },
        get_date: function (date) {
            var dateParts = date.split("-");
            return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
        },
        get_price(variation) {
            // returns [price, sale_price], if sale_price doesnt match - [price, price]
            if (variation.sale_start && variation.sale_end && variation.sale_price) {
                var sale_start = this.get_date(variation.sale_start).getTime();
                var sale_end = this.get_date(variation.sale_end).getTime();
                var now = Date.now();
                if (sale_start < now && now < sale_end) {
                    return [variation.price, variation.sale_price];
                }
            }
            return [variation.price, variation.price];
        },
        order(event) {
            // redirect to order page
            event.preventDefault();
            var lang = this.documentLanguage;
            var id = this.selected_variant.id;
            var qty = this.quantity;
            window.location = `/${lang}/cart/${id}?order&qty=${qty}`;
        },
        to_cart(event) {
            // add to cart
            event.preventDefault();
            var lang = this.documentLanguage;
            var id = this.selected_variant.id;
            var qty = this.quantity;
            window.location = `/${lang}/cart/${id}?qty=${qty}`;
        },
    },
    mounted() {
        axios.get("/api/product/" + this.id).then((response) => (this.info = response.data));
    },
};
</script>