<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="font-size: 19px;">
                        Прогноз на текущий месяц
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
                            <div class="col-md-6">
                                <div class="row">
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

                                <div v-if="items.length">
                                    <div v-for="(item, i) in items" :key="`item-${i}`">
                                        <Item
                                            :item="item"
                                            :isCurrentDate="isCurrentDate"
                                            @update-items="fetchItems"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                Общий план: <span v-number_format="responseItems.sumPlan"></span>грн.<br>
                                Фактический план: <span v-number_format="responseItems.sumCurrent"></span>грн. <small>({{ responseItems.percentCurrent }}%)</small><br>
                                Прогноз: <span v-number_format="responseItems.sumForecast"></span>грн. <small>({{ responseItems.percentForecast }}%)</small><br>
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
      props: ['subtitle', 'sitename'],
      data () {
        return {
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
          axios.get('/api/sites/change?site_id=' + site_id).then(() => {
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
          axios.get(`/api/categories?month=${this.getMonth}&year=${this.getYear}`).then(response => {
            this.responseItems = response.data;
            this.items = this.responseItems.categories;
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
