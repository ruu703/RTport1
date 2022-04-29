<template>
    <div class="p-container__panel">
        <div class="p-container__inner p-container__inner--projectmsg">
            <MessageList 
            v-for="message in publicMessage" 
            :key="message.id"
            :message="message"
            :project="project"
            ></MessageList>
                       
            <div v-if="project.close_flg == 0 && project.delete_flg == 0">
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
                           
                <TextCount :text-length="message"></TextCount>

                <div class="p-container__btnwrap">
                    <button class="c-btn p-container__submit p-container__submit--black" @click="postMessage" v-if="user !== null" :disabled="!display">
                        送信
                    </button>
                    <a href="https://ruka.sakura.ne.jp/match/register" class="c-btn p-container__submit p-container__submit--black" v-else>
                        <span class="u-indention">会員登録して</span><span class="u-indention">メッセージする</span>
                    </a>
                </div>
            </div>
            <div v-else>
                この案件の募集は終了しました
            </div>
         </div>
    </div>
</template>

<script>
import MessageList from './PublicMessageListComponent.vue'
import TextCount from './TextCountComponent.vue'

export default {
    props:{
        user:{
            type: Object,
            required: false
        }
    },
    data(){
        return{
            publicMessage: '',
            project: '',
            message: '',
            errors: [],
        }
    },
    components:{
        MessageList,
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
            e.preventDefault();
        },
        getMessage(){
            // projectテーブルのidを取得
            let id = this.$route.path.substr(9);
            // console.log('id : '+id);
            axios.get('/match/api/p_message/'+id)
            .then(response => {
                // console.log(response.data);
                this.publicMessage = response.data.message,
                this.project = response.data.project
            })
            .catch(error => console.log(error)) 
        },
        postMessage(e){

            // バリデーションチェック
            this.checkForm(e);

            // バリデーションOKかつ、user.idとproject.idがある場合
            if(this.errors.length == 0 && this.user.id && this.project.id){

            // メッセージをDBに保存
            axios.post('/match/api/p_message',{
            message: this.message,
            user_id: this.user.id,
            project_id: this.project.id
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