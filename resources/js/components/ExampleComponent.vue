<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <toolbar
                        :spinner="spinner"
                        :subtitle="subtitle"
                        @reset="reset"
                    ></toolbar>

                    <div class="card-body" style="font-size: 17px;">
                        <div class="row">
                            <filterd
                                @update-items="updateFilter($event)"
                                :month="getMonth"
                                :year="getYear"
                            ></filterd>

                            <div class="col-md-12">
<!--                              Старый список: <toggle-button v-model="myDataVariable"/>-->
                              <div class="container-statistic">
                                <statistic
                                  :index="1"
                                  :goal="statistic.sumPlan"
                                  :progress="statistic.sumCurrent"
                                  :title="`План факт. (${statistic.percentCurrent}%)`"
                                  symbol="грн."
                                ></statistic>
                                <statistic
                                  :index="2"
                                  :goal="statistic.sumPlan"
                                  :progress="statistic.sumForecast"
                                  :title="`Прогноз плана (${statistic.percentForecast}%)`"
                                  symbol="грн."
                                ></statistic>

                                <statistic
                                  :index="3"
                                  :goal="100"
                                  :progress="statistic.sumEfficiency"
                                  title="Общий КПД"
                                  symbol="%"
                                ></statistic>
                              </div>
                                <div v-if="items.length">
                                    <div class="board">
                                        <div class="card-block" v-for="(item, i) in items" :key="`item-new-${i}`">
                                            <FlipCard>
                                                <template v-slot:front="{ toggle }">
                                                <ItemCard
                                                    :item="item"
                                                    :toggle="toggle"
                                                    @update-items="fetchItems"
                                                ></ItemCard>
                                                </template>
                                                <template v-slot:back="{ toggle }">
                                                    <form-add
                                                        :cancel="toggle"
                                                        :category_id="item.id"
                                                        :is_write="is_write"
                                                        @update-items="fetchItems"
                                                    ></form-add>
                                                    <hr>
                                                    <div v-if="item.forecastService">
                                                        Рекомендовано: <span v-number_format="item.forecastService.performanceToDay"></span> {{ item.unit }} в день
                                                    </div>
                                                </template>
                                            </FlipCard>
                                        </div>
                                    </div>
<!--                                    <hr>-->
                                </div>
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
    import ItemCard from './ItemCard'
    import FlipCard from './FlipCard'
    import FormAdd from './FormAdd'
    import Toolbar from './Toolbar'
    import Filterd from './Filter'
    import Statistic from './Statistic'
    import { mapGetters } from 'vuex'

    export default {
      components: {Item, ItemCard, FlipCard, FormAdd, Toolbar, Filterd, Statistic},
      props: ['subtitle', 'sitename'],
      data () {
        return {
          is_write: false,
          spinner: false,
          site_id: 0,
          items: [],
          responseItems: {},
         }
      },
      computed: {
        ...mapGetters([
            'message', 'currentMonth', 'currentYear', 'isCurrentDate', 'statistic'
        ]),
        getYear: {
          get () {
            return this.$store.state.getYear;
          },
          set (value) {
            this.$store.commit('getYear', value)
          }
        },
        getMonth: {
          get () {
            return this.$store.state.getMonth;
          },
          set (value) {
            this.$store.commit('getMonth', value)
          }
        },
        statusImg: function () {
          let sumForecast = this.responseItems.percentForecast;

          if (sumForecast < 15) {
            return 0;
          }
          if (sumForecast < 25) {
            return 1;
          }
          if (sumForecast < 35) {
            return 1.1;
          }
          if (sumForecast < 45) {
            return 2.2;
          }
          if (sumForecast < 50) {
            return 2;
          }
          if (sumForecast < 65) {
            return 3;
          }
          if (sumForecast < 80) {
            return 4;
          }
          return 5;
        }
      },
      methods: {
          reset () {
              this.getMonth = this.currentMonth;
              this.getYear = this.currentYear;
              this.fetchItems();
          },
          updateFilter (params) {
              this.getMonth = params.getMonth;
              this.getYear = params.getYear;
              this.site_id = params.site_id;
              this.is_write = params.is_write;

              this.fetchItems();
          },
        fetchItems () {
          this.spinner = true
          this.$store.dispatch('fetchItems')
          axios.get(`/api/categories?month=${this.getMonth}&year=${this.getYear}`).then(response => {
            this.responseItems = response.data;
            this.items = this.responseItems.categories;

            setTimeout(() => {
              this.spinner = false
            }, 500)
          })
        }
      },
      mounted() {
        this.fetchItems();
      }
    }
</script>

<style lang="scss" scoped>
  .container-statistic {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin-left: 100px;margin-bottom: 20px;
  }

  .list-group {
    border-radius: 15px;
    li {
      /*background-color: #219ffe;*/
      /*color: #fff;*/
    }
  }
  .hr-style {
    border : 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), #7a7b81, rgba(0, 0, 0, 0));
  }

  .right-col {
    color: rgb(102, 102, 103);
    /*border: 1px solid #ddd;*/
    font-size: 16px;
  }
</style>
