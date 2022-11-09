const state = {
   user: {
      full_name: '',
      birth: '',
      sex: '',
      city: '',
      email: '',
      place_of_work: '',
      img_url: ''
   },
   // items: localStorage.getItem('vuejs__store') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store')),
}

// getters
const getters = {
   getUser: (state, getters, rootState) => {
      console.log("Test 1")
      return state.user;
   },

}

// actions
const actions = {

   // inCart({state, commit}, id) {
   //     return (state.items.filter(item => item.product.id === id)).length
   // },

}

// mutations
const mutations = {

   // decrementItemQuantity(state, id) {
   //     const cartItem = state.items.find(item => item.product.id === id)
   //     if (cartItem.quantity > 1)
   //         cartItem.quantity--;
   // },
   // removeItem(state, id) {
   //     let tmp = state.items.filter((item) => item.product.id !== id);
   //     state.items = tmp
   //     //commit('setCartItems',tmp)
   // },


}

export default {
   state,
   getters,
   actions,
   mutations
}