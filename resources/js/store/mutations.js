export const mutations = {
  loader(state, isLoader) {
    state.loader = isLoader
  },

  getMonth(state, value) {
    state.message = 'value';
    state.getMonth = value;
  },

  getYear(state, value) {
    state.getYear = value;
  },

  SET_ITEMS(state, value) {
    state.statistic = value.data;
  }
}
