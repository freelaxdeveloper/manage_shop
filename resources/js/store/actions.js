import axios from 'axios'

export default {

  loader({ commit }, loader) {
    commit('loader', loader)
  },

  fetchItems({ commit, state }) {
    axios.get(`/api/categories?month=${state.getMonth}&year=${state.getYear}`).then(response => {
      commit('SET_ITEMS', response)
      // this.responseItems = response.data;
      // this.items = this.responseItems.categories;
    })
  }
}
