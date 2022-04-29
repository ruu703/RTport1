<template>
    <div class="p-container__panel">
        <div class="p-container__inner p-container__inner--projectmsg">
            <DirectMessageList 
            v-for="board in boardData"
            :key="board.id"
            :board="board"
            :partnerUserInfo="partnerUserInfo"
            :myUserInfo="myUserInfo"
            ></DirectMessageList>
                        
            <label for="message">
                メッセージを送る
            </label>
            <textarea class="c-form c-form--textarea p-container__project__textarea" rows="3" v-model.trim="message">
            </textarea>
            <span class="c-errormsg" role="alert" v-if="errors.length">
                <ul class="c-errormsg__ul">
                    <li class="c-errormsg__li" v-for="error in errors" :key="error">
                        {{ error }}
                    </li>
                </ul>
            </span>

            <span class="c-errormsg" role="alert" v-html="errors.message">
            </span>
                            
            <TextCount :text-length="message"></TextCount>

            <div class="p-container__btnwrap">
                <button type="submit" class="c-btn p-container__submit p-container__submit--black" @click="postMessage" :disabled="!display">
                    送信
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import DirectMessageList from './DirectMessageListComponent.vue'
import TextCount from './TextCountComponent.vue'

export default {
    // props:['partnerUserInfo', 'myUserInfo'],
    props:{
        partnerUserInfo:{
            type: Object,
            required: true
        },
        myUserInfo:{
            type: Object,
            required: true
        }
    },
    data(){
        return{
            message: '',
            errors: [],
            boardData: []
        }
    },
    components:{
        DirectMessageList,
        TextCount
    },
    computed:{
        // メッセージ入力欄を埋めた場合に投稿ボタンを活性化する
        display(){
                if(this.message){

                return true;
            }
            return false;
        }
    },
    methods: {
        // テキストエリア　バリデーション
        checkForm(e){

            // メッセージ入力があり、１０００文字以内の場合
            if(this.message && this.message.length <= 1000){
                return true;
            }

            this.errors = [];

            // メッセージが空の場合　エラーメッセージをセット
            if(!this.message){
                this.errors.push('メッセージがありません');
            }
            // メッセージが1000文字以上の場合　エラーメッセージをセット
            if(this.message.length >= 1000){
                this.errors.push('1000文字以内で入力してください');
            }
            // 自分又は相手のidが空の場合　エラーメッセージをセット
            if(!this.myUserInfo.id || !this.partnerUserInfo.id){
                this.errors.push('メッセージの投稿に失敗しました');
            }
            e.preventDefault();
        },
        getMessage(){
            axios.get('/match/api'+this.$route.path)
            .then(response => {
                response.data.forEach((object, index) => {
                    this.$set(this.boardData,[index], object)
                })
            })
            .catch(error => console.log(error)) 
        },
        postMessage(e){

            // バリデーションチェック
            this.checkForm(e);

            // バリデーションOKなら処理を継続
            if(this.errors.length == 0){
            
            // メッセージをDBに保存
            axios.put('/match/api'+this.$route.path,{
            message : this.message,
            send_user : this.myUserInfo.id,
            receive_user : this.partnerUserInfo.id,
           },this.message = '')
          .then(response => {
              this.getMessage();
            //   console.log(response.data)
          })
          .catch(error => console.log(error))
         }
        }
    },
     created(){
        this.getMessage();
    }
}
</script>