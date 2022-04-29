<template>
    <div>
        <div v-if="formSent">
            <label for="title" class="c-label">
                案件名
            </label>
            <div >
                <input type="text" class="c-form c-form--input" id="title" value="" v-model="title" required>
            </div>

            <span class="c-errormsg" role="alert" v-html="errors.title">
            </span>
                                    
            <label for="category_id" class="c-label">
                案件種別
            </label>
            <div>
                <span class="c-form c-form--radiotext">
                    <input type="radio" name="category_id" id="category_id" value="1" class="c-form c-form--radio" @click="isShow = true; resetCategory()" v-model="category_id">
                    単発案件
                </span>
                <span  class="c-form c-form--radiotext">
                    <input type="radio" name="category_id" id="category_id" value="2" class="c-form c-form--radio" @click="isShow = false; resetCategory()" v-model="category_id">
                    レベニューシェア案件
                </span>
            </div>

                                        
            <span class="c-errormsg" role="alert" v-html="errors.category_id">
            </span>

            <transition name="fade" mode="out-in">         
                <div v-if="isShow" key="fee1">
                    <label for="reword" class="c-label">
                        報酬額
                    </label>
                                        
                    <div class="p-container__doubleinput">
                        <div class="p-container__doubleinput-rps">
                            <input type="number" name="fee_low" class="c-form c-form--input" id="reword" value=""   v-model.number="fee_low" min="1000" step="1000" required>
                            <span class="p-container__doubleinput-span">
                                〜
                            </span>
                        </div>

                        <div class="p-container__doubleinput-rps">
                            <input type="number" name="fee_high" class="c-form c-form--input"  value=""   v-model.number="fee_high" min="1000" step="1000" required>
                            <span class="p-container__doubleinput-span">
                                円
                            </span>
                        </div>
                    </div>

                                
                    <span class="c-errormsg" role="alert" v-html="errors.fee_low">
                    </span>
                    <span class="c-errormsg" role="alert" v-html="errors.fee_high">
                    </span>
                </div>
                                        
                <div v-else key="fee2">                      
                    <label for="rate" class="c-label">
                        収益分配率
                    </label>             
                    <div  class="p-container__doubleinput">
                        <div class="p-container__doubleinput-rps">
                            <input type="number" name="fee_low" class="c-form c-form--input" id="rate" value=""  step="1" v-model="fee_low" min="1" max="99" required>
                            <span  class="p-container__doubleinput-span">〜</span>
                        </div>
                        <div class="p-container__doubleinput-rps">
                            <input type="number" name="fee_high" class="c-form c-form--input"  value=""  step="1" v-model="fee_high" min="1"  max="99" required>
                            <span class="p-container__doubleinput-span">％</span>
                        </div>
                    </div>

                    <span class="c-errormsg" role="alert" v-html="errors.fee_low">
                    </span>
                    <span class="c-errormsg" role="alert" v-html="errors.fee_high">
                    </span>

                </div>
            </transition>

            <label for="detail" class="c-label">
                募集内容
            </label>
                                            
            <textarea class="c-form c-form--textarea" rows="5" name="detail" id="detail" v-model="detail" required>
            </textarea>
                                                    
            <span class="c-errormsg" role="alert" v-html="errors.detail">
            </span>
                                            
            <TextCount :text-length="detail"></TextCount>
                                
            <div class="p-container__btnwrap">
                <button class="c-btn p-container__submit p-container__submit--black" @click="openModal" :disabled="!display">
                    登録
                </button>
            </div>

            <Modal @close="closeModal" v-if="modal == true">
                <p class="mymodal">案件を投稿します。よろしいですか？</p>
                <div class="modalflex">
                    <button class="mymodal c-btn c-btn--modal" @click="this.clickEvents">はい</button>
                    <button class="mymodal c-btn c-btn--modal" @click="this.closeModal">キャンセル</button>
                </div>
            </Modal>
        </div>

        <div v-else class="p-container__posted">
            <p class="u-margin--l u-font--size-m">
            {{ message }}
            </p>
    
            <div>
                <a href="https://ruka.sakura.ne.jp/match/projectform" class="c-btn p-container__decision">続けて投稿する</a>
            </div>
      
            <div class="u-margin--l">
                <a href="https://ruka.sakura.ne.jp/match/mypage">マイページへ戻る</a>
            </div>
        </div>
    </div>
</template>

<script>
import TextCount from './TextCountComponent.vue'
import Modal from './ModalComponent.vue'

export default {
    props: {
        userId:{
            type: Number,
            required: true
        }
    },
    data(){
        return{
            modal: false,
            isShow: true,
            title: '',
            category_id: 1,
            fee_low: '',
            fee_high: '',
            detail: '',
            errors: {},
            formSent: true,
            message: ''
        }
    },
    components:{
        TextCount,
        Modal
    },
    computed:{
        // 全ての入力欄を埋めた場合に投稿ボタンを活性化する
        display(){
                if(this.title && this.fee_low && this.fee_high && this.detail){

                return true;
            }

            return false;
        }
    },
    methods:{
        openModal(){
            this.modal = true;
        },
        // 案件種別切替で、入力値とエラーをリセットする
        resetCategory(){

            if(this.fee_low || this.fee_high){
                this.fee_low = '';
                this.fee_high = '';
            }

            if(this.errors.fee_low || this.errors.fee_high){
                this.errors.fee_low = '';
                this.errors.fee_high = '';
            }

        },
        // laravel側へ投稿データをaxiosのpost通信でDBへ保存する
        postProject(){

            let params = {
                title: this.title,
                category_id: this.category_id,
                fee_low: this.fee_low,
                fee_high: this.fee_high,
                detail: this.detail,
                order_user_id :this.userId
            };

            this.errors = {};

            let self = this;

            axios.post('/match/api/projectform', params)
            .then((response) =>{
                self.formSent = false;
                self.message = response.data.success;
            })
            .catch(function(error){

            // バリデーションエラーがあればthis.errorsにエラーをセットする
            let errors = {};

            let errormessage = {...error.response.data.errors};

        
            for(let key in errormessage) {

                errors[key] = errormessage[key].join('<br>');

             }

            self.errors = errors;

            });
        },
        clickEvents(){

            this.postProject();

            setTimeout(
             this.remove
            , 1000)
            setTimeout(
             this.closeModal
            , 500)
        },
        closeModal(){
            this.modal = false;
        }
    },
    created(){
        this.formSent = true;
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
/* モーダル */
.mymodal{
        margin: 15px 0; 
        display: flex;
       align-items: center;
       justify-content: center;   
}
.modalflex{
    display: flex;
    justify-content: space-around;
}

</style>