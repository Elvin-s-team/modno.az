<template>
    <div id="buy-it-guest" class="modal" tabindex="-1">
        <div class="layout modal-content">
            <div class="row">
                <h5 class="col s12">{{ $t('buyItGuest.title') }}</h5>
                <form v-on:submit.prevent="buy" role="form" method="POST" action="register"
                      @keydown="errors.clear($event.target.name)">
                    <div class="input-field col s12">
                        <label class="active error" v-if="errors.has('name')"
                               v-text="errors.get('name')"></label>
                        <input :placeholder="namePlaceholder" id="name" type="text" name="name" class="validate"
                               v-model="name">
                        <label for="name" class="active" v-show="!errors.has('name')">{{ $t('signup.name')
                            }}</label>
                    </div>
                    <div class="input-field col s12">
                        <label class="active error" v-if="errors.has('number')"
                               v-text="errors.get('number')"></label>
                        <input :placeholder="numberPlaceholder" id="number" type="text" name="number" class="validate"
                               v-model="number">

                        <label for="number" class="active" v-show="!errors.has('number')">{{ $t('signup.number')
                            }}</label>
                    </div>

                    <div class="col s12">
                        <a @click.prevent="buy" :disabled="errors.any()" class="modal-action waves-effect waves-green btn">{{ $t('buyItGuest.buyButton') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Errors from '../../classes/Errors';

    export default {
        props: {
            products: {},
            fromCart: false
        },
        data() {
            return {
                name: '',
                number: '',
                errors: new Errors(),
                numberPlaceholder: this.getRandom(['994552002020','994518888888','994707070707']),
                namePlaceholder: this.getRandom(['Ilon Mask', 'Mark Zuckerberg', 'Stiv Jobs'])
            }
        },
        methods: {
            getRandom(array) {
                return array[Math.floor(Math.random()*array.length)];
            },
            buy() {
                axios.post('order', {
                    products: this.products,
                    name: this.name,
                    number: this.number,
                    fromCart: this.fromCart
                }).then(function (response) {
                    this.$store.state.errors.record(response.data.errors);
                    this.$store.state.messages.record(response.data.messages);
                    this.$store.state.cartItems = [];
                    $('#buy-it-guest').modal('close');
                    $('#flash-message').modal('open');
                }.bind(this)).catch(error => {
                    this.errors.record(error.response.data);
                });
            }
        }
    }
</script>