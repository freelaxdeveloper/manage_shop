<template>
    <div>
        <input
            type="text"
            class="form-control form-control-sm"
            style="display: inline-block; width: 60%;"
            :disabled="disabled"
            v-model="money"
        >
        <button
            class="btn btn-primary btn-sm"
            :disabled="disabled"
            @click="submit"
        >Добавить</button>
        <a href="#" class="btn btn-light btn-sm" @click.prevent="cancel">Отмена</a>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  import axios from "axios";

  export default {
    name: "FormAdd",
    props: ['cancel', 'category_id', 'is_write'],
    data () {
        return {
            money: '',
        }
    },
    computed: {
      ...mapGetters([
        'isCurrentDate'
      ]),
        disabled: function () {
            return !this.is_write || !this.isCurrentDate || (this.item && !this.item.forecastService)
        }
    },
    methods: {
        submit () {
            axios.post('/api/statistics', {
                category_id: this.category_id,
                count: this.money,
            }).then(() => {
                this.money = '';
                this.cancel();
                this.$emit('update-items');
            });
        }
    }
  }
</script>

<style scoped>

</style>
