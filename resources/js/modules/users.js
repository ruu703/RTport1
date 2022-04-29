const state = {
    user: [],
    preview_img: null,
    errors: {},
    isEnter: false,
    files: [],
    formSent: false,
    message: '',
};
const getters = {
    user(state){
        return state.user;
    },
    preview_img(state){
        return state.preview_img;
    },
    errors(state){
        return state.errors;
    },
    enter(state){
        return state.isEnter;
    },
    files(state){
        return state.files;
    },
    formSent(state){
        return state.formSent;
    },
    message(state){
        return state.message;
    }
};
const mutations = {
    setUser(state, data){

        let key = Object.keys(data);

        if(key.length == 1){
            // 一部プロパティ 更新の場合
        　　 state.user[key] = data[key];
            // console.log('一部の更新です');
        }else{
        　　 state.user = data;
            // console.log('userをセットしました');
        }
    },
    updateImg(state, data){
        state.preview_img = data;
    },
    setErrors(state, data){

        let key = Object.keys(data);

        if(key.length == 1){
            // 一部プロパティ 更新の場合
            // 配列の変更検知のためsetを使う
            Vue.set(state.errors, key, data[key]);
            // console.log('一部の更新です');
        }else{
        　　 state.errors = data;
            // console.log('errorsをセットしました');
        }
    },
    isEnter(state, data){
        state.isEnter = data;
    },
    setFiles(state, data){
        state.files =  data;
    },
    setFormSent(state, data){
        state.formSent = data;
    },
    setMessage(state, data){
        state.message = data;
    }
};
const actions = {
    setUser({commit}, data){
        if(data){
            commit('setUser', data);
        }
    },
    updateImg(context, data){
        context.commit('updateImg', data);
    },
    setErrors(context, data){
        context.commit('setErrors', data);
    },
    isEnter(context, data){
        context.commit('isEnter', data);
    },
    setFiles(context, data){
        context.commit('setFiles', data);
    },
    setFormSent(context, data){
        context.commit('setFormSent', data);
    },
    setMessage(context, data){
        context.commit('setMessage', data);
    },
    updateUser({commit}, data){

        return axios.post('/match/api/profileform', data)
        .then((response) => {
            // レスポンスが200の時の処理
            commit('setFiles', []);
            commit('updateImg', '');
            commit('setFormSent', true);
            commit('setMessage', response.data.success);

          })
          .catch(error => {

            if(error.response) {
              // レスポンスが200以外の時の処理

            let errors = {};

            let errormessage = {...error.response.data.errors};

            // console.log(errormessage);

            for(let key in errormessage) {

                errors[key] = errormessage[key].join('<br>');
                // console.log(errors[key]);
            }
            
            commit('setErrors', errors);

            }
        });
    }
}
export default {
    state,
    getters,
    mutations,
    actions
};