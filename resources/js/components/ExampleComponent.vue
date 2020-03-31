<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-size: 19px;">
                        Прогноз на текущий месяц
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{ subtitle }}
                        </h6>
                    </div>

                    <div class="card-body" style="font-size: 17px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" v-model="getMonth">
                                            <option value="1">Январь</option>
                                            <option value="2">Февраль</option>
                                            <option value="3">Март</option>
                                            <option value="4">Апрель</option>
                                            <option value="5">Май</option>
                                            <option value="6">Июнь</option>
                                            <option value="7">Июль</option>
                                            <option value="8">Август</option>
                                            <option value="9">Сентябрь</option>
                                            <option value="10">Октябрь</option>
                                            <option value="11">Ноябрь</option>
                                            <option value="12">Декабрь</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="items.length">
                                    <div v-for="(item, i) in items" :key="`item-${i}`">
                                        <Item :item="item" @update-items="fetchItems" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                Общий план: <span v-number_format="responseItems.sumPlan"></span>грн.<br>
                                Фактический план: <span v-number_format="responseItems.sumCurrent"></span>грн. <small>({{ responseItems.percentCurrent }}%)</small><br>
                                Выполенение плана: <span v-number_format="responseItems.sumForecast"></span>грн. <small>({{ responseItems.percentForecast }}%)</small><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Item from './Item'

    export default {
      components: {Item},
      props: ['subtitle'],
      data () {
        return {
          items: [],
          responseItems: {},
          getMonth: (new Date).getMonth() + 1,
        }
      },
      watch: {
        getMonth: function () {
          this.fetchItems();
        }
      },
      methods: {
        fetchItems () {
          axios.get(`/api/categories?month=${this.getMonth}`).then(response => {
            this.responseItems = response.data;
            this.items = this.responseItems.categories;
          })
        }
      },
      mounted() {
        this.fetchItems();
      }
    }
</script>
