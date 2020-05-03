<template>
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
</template>

<script>
  import axios from "axios";

  export default {
    name: "Filterd",
      props: ['month', 'year'],
      data () {
        return {
            sites: [],
            site_id: 0,
            is_write: false,
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
      watch: {
          getMonth: function () {
              this.fetchItems();
          },
          getYear: function () {
              this.fetchItems();
          },
          site_id: function (val) {
              this.changeSite(val)
          },
          month: function (val) {
              this.getMonth = val;
          },
          year: function (val) {
              this.getYear = val;
          },
      },
      computed: {
          years: function () {
              return this.range(this.getYear - 2, this.getYear + 2)
          },
      },
      mounted() {
        this.fetchSites();
        this.fetchCurrentSite();
      },
      methods: {
          fetchItems () {
              this.$emit('update-items', {
                  getMonth: this.getMonth,
                  getYear: this.getYear,
                  getMonth: this.getMonth,
                  site_id: this.site_id,
                  is_write: this.is_write,
              });
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
          changeSite (site_id) {
              axios.get('/api/sites/change?site_id=' + site_id).then(response => {
                  this.is_write = response.data.is_write
                  this.fetchItems();
              })
          },
      }
  }
</script>

<style scoped>

</style>
