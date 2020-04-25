<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-size: 19px;">
                        Прогноз на текущий месяц
                        <div
                            v-if="spinner"
                            class="spinner-grow text-warning"
                            style="width: 3rem; height: 3rem; position: absolute;"
                            role="status"
                        >
                            <span class="sr-only">
                                Loading...
                            </span>
                        </div>

                        <h6
                            v-if="isCurrentDate"
                            class="card-subtitle mb-2 text-muted"
                        >
                            {{ subtitle }}

                        </h6>
                        <div v-else>
                            <button
                                @click="getMonth = currentMonth, getYear = currentYear"
                                class="btn btn-primary btn-sm"
                            >
                                Сбросить
                            </button>
                        </div>

                    </div>

                    <div class="card-body" style="font-size: 17px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div
                                    class="float-md-right card-subtitle mb-2 text-muted"
                                    style="font-size: 15px;"
                                >
                                    <select
                                        class="form-control"
                                        v-model="site_id"
                                    >
                                        <option
                                            v-for="(site, i) in sites"
                                            :key="`site-${i}`"
                                            :value="site.id"
                                        >
                                            {{ site.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-3">
                                        <select class="form-control" v-model="getMonth">
                                            <option
                                                v-for="month in months"
                                                :key="`month-item-${month.id}`"
                                                :value="month.id"
                                            >
                                                {{ month.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" v-model="getYear">
                                            <option
                                                v-for="year in years"
                                                :key="`year-item-${year}`"
                                                :value="year"
                                            >
                                                {{ year }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="hr-style">
                            </div>

                            <div class="col-md-6">

                                <div v-if="items.length">
                                    <div v-for="(item, i) in items" :key="`item-${i}`">
                                        <Item
                                            :item="item"
                                            :isCurrentDate="isCurrentDate"
                                            :is_write="is_write"
                                            @update-items="fetchItems"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="right-col">
<!--                                    <div style="width: 100%; text-align: center;">-->
<!--                                        <img :src="`/images/money/${statusImg}.png`" width="300px"><br>-->
<!--                                    </div>-->
                                    <ul class="list-group">
<!--                                        <li class="list-group-item d-flex justify-content-between align-items-center">-->
<!--                                            Общий план-->
<!--                                            <span class="badge badge-light badge-pill"><span v-number_format="responseItems.sumPlan"></span>грн.</span>-->
<!--                                        </li>-->
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Фактический план
                                            <span class="badge badge-light badge-pill"><span v-number_format="responseItems.sumCurrent"></span>грн. <small>({{ responseItems.percentCurrent }}%)</small></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Прогноз
                                            <span class="badge badge-light badge-pill"><span v-number_format="responseItems.sumForecast"></span>грн. <small>({{ responseItems.percentForecast }}%)</small></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Общий КПД
                                            <span class="badge badge-light badge-pill"><span v-number_format="responseItems.sumEfficiency"></span>%</span>
                                        </li>
                                    </ul>
<!--                                    Общий план: <span v-number_format="responseItems.sumPlan"></span>грн.<br>-->
<!--                                    Фактический план: <span v-number_format="responseItems.sumCurrent"></span>грн. <small>({{ responseItems.percentCurrent }}%)</small><br>-->
<!--                                    Прогноз: <span v-number_format="responseItems.sumForecast"></span>грн. <small>({{ responseItems.percentForecast }}%)</small><br>-->
<!--                                    Общий КПД: <span v-number_format="responseItems.sumEfficiency"></span>%<br>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
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

<script>
    import axios from 'axios'
    import Item from './Item'

    export default {
      components: {Item},
      props: ['subtitle', 'sitename'],
      data () {
        return {
          is_write: false,
          spinner: false,
          site_id: 0,
          sites: [],
          items: [],
          responseItems: {},
          getMonth: (new Date).getMonth() + 1,
          getYear: (new Date).getFullYear(),
          currentMonth: (new Date).getMonth() + 1,
          currentYear: (new Date).getFullYear(),
          months: [
            {id: 1, name: 'Январь'},
            {id: 2, name: 'Февраль'},
            {id: 3, name: 'Март'},
            {id: 4, name: 'Апрель'},
            {id: 5, name: 'Май'},
            {id: 6, name: 'Июнь'},
            {id: 7, name: 'Июль'},
            {id: 8, name: 'Август'},
            {id: 9, name: 'Сентябрь'},
            {id: 10, name: 'Октябрь'},
            {id: 11, name: 'Ноябрь'},
            {id: 12, name: 'Декабрь'},
          ],
        }
      },
      computed: {
        years: function () {
          return this.range(this.getYear - 2, this.getYear + 2)
        },
        isCurrentDate: function () {
          return this.getMonth === this.currentMonth && this.getYear === this.currentYear;
        },
        statusImg: function () {
          let sumForecast = this.responseItems.percentForecast;
          console.log(sumForecast)

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
      watch: {
        getMonth: function () {
          this.fetchItems();
        },
        getYear: function () {
          this.fetchItems();
        },
        site_id: function (val) {
          this.changeSite(val)
        }
      },
      methods: {
        changeSite (site_id) {
          axios.get('/api/sites/change?site_id=' + site_id).then(response => {
            this.is_write = response.data.is_write
            this.fetchItems();
          })
        },
        fetchSites () {
          axios.get('/api/sites').then(response => {
            this.sites = response.data.sites
          })
        },
        fetchCurrentSite () {
          axios.get('/api/sites/current').then(response => {
            this.site_id = response.data.site.id
          })
        },
        range (start, end) {
          return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },
        fetchItems () {
          this.spinner = true
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
        this.fetchSites();
        this.fetchCurrentSite();
      }
    }
</script>
