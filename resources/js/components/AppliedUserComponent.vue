<template>
    <div>
        <div v-if="closedWithContractor()">
            受注者を決定しました!
        </div>
        <div v-else-if="closedWithoutContractor()">
            受注者を決定せずに終了しました
        </div>
        <div v-else-if="!appliedUsers">
            応募はありません
        </div>

        <label
        :for="user.apply_user_id" 
        v-for="user in appliedUsers" 
        :key="user.apply_user_id">
        <p v-if="appliedUsers && user.received_user_id == user.apply_user_id">受注者</p>
        <div class="p-user p-user--applicant u-margin-bottom--20" :class="{ received : appliedUsers && user.received_user_id == user.apply_user_id }">
            <div class="p-user__img">
                <a :href='"https://ruka.sakura.ne.jp/match/message/"+user.boardId'>
                    <img :src='"https://ruka.sakura.ne.jp/match/"+user.profile_img' alt="プロフィール画像" class="p-user__avator p-user__avator--applyuser">
                </a>
            </div>
            <div class="p-user__name">
                <a :href='"https://ruka.sakura.ne.jp/match/message/"+user.boardId'>
                    <span class="p-user__nickname">
                        {{ user.nickname }}
                    </span> さん
                </a>
            </div>
            <div  class="p-user__radio" v-if="appliedUsers && user.received_user_id == null && user.close_flg == 0">
                <input type="radio" name="apply_user_id" :id="user.apply_user_id" :value=" user.apply_user_id " v-model="id">
            </div>
        </div>
        </label>

        <span class="c-errormsg" role="alert" v-if="errors.length">
            <ul class="c-errormsg__ul">
                <li class="c-errormsg__li" v-for="error in errors" :key="error">
                    {{ error }}
                </li>
            </ul>
        </span>

        <div class="p-container__btnwrap" v-if="closeRecruitment()">
            <button class="c-btn p-container__decision" @click.prevent="postAppliedUser">
            受注者を決定して募集終了
            </button>
        </div>
        <div class="p-container__btnwrap" v-if="deleteRecruitment()">
            <button class="c-btn p-container__decision" @click.prevent="openModal">
            募集終了
            </button>
        </div>

        <Modal @close="closeModal" v-if="modal">
        <p class="mymodal">受注者を決定せずに募集を終了します。<br>募集を終了して宜しいですか？</p>
        <div class="modalflex">
        <button class="mymodal c-btn c-btn--modal" @click="this.deleteProject">はい</button>
        <button class="mymodal c-btn c-btn--modal" @click="this.closeModal">キャンセル</button>
        </div>
        </Modal>
    </div>
</template>

<script>
import Modal from './ModalComponent.vue'

export default {
    data(){
        return{
            id: '',
            errors: [],
            message: '',
            appliedUsers: [],
            formSent: false,
            modal: false
        }
    },
    components: {
        Modal
    },
    methods:{
        // 入力チェック　バリデーション
        checkForm(e){

        if(this.apply_user_id){
            return true;
        }

        this.errors = [];

        // ラジオボタンが未選択の場合　エラーメッセージをセット
        if(!this.id){
            this.errors.push('応募者を選択してください');
        }

        e.preventDefault();
        
        },
        getAppliedUser(){
            // projectテーブルのidを取得
            let id = this.$route.path.substr(9);

            axios.get('/match/api/applyuser/'+id)
            .then(response => {
                // 応募者がいる場合this.appliedUsersにレスポンスデータをセット
                if(typeof response !== 'undefined'){
                this.appliedUsers = response.data
                // console.log('レスポンスがあります');
                // console.log(response);
                }
            })
            .catch(erorr => 
            console.log(error)
            );
        },
        postAppliedUser(e){

            // バリデーションチェック
            this.checkForm(e);

            // console.log('バリデーションOKです');

            // projectテーブルのidを取得
            let id = this.$route.path.substr(9);

            if(this.errors.length == 0){

                // 応募者IDをテーブルに保存
                axios.post('/match/api/applyuser',{
                    received_user_id:this.id,
                    id:id,
                    close_flg:1
                    })
                .then(response => {
                    this.getAppliedUser();
                    // console.log(response.data);
                })
                .catch(error => 
                console.log(error)
                )
            }

        },
        postCloseProject(){

            this.errors = [];

             // projectテーブルのidを取得
            let id = this.$route.path.substr(9);

            // projectテーブルのcolse_flgを1にする
            const self = this;

            axios.delete('/match/api/applyuser/'+id)
            .then(response => {
                self.getAppliedUser();
                // console.log(response.data);
            })
            .catch(error => 
            console.log(error)
            )
        },
        openModal(){
            this.modal = true;
        },
        closeModal(){
            this.modal = false;
        },
        deleteProject(){

            this.postCloseProject();

            setTimeout(
             this.remove
            , 1000)
            setTimeout(
             this.closeModal
            , 500)
        },
        closedWithContractor(){
            if(this.appliedUsers[0] && this.appliedUsers[0].received_user_id){
                return true;
            }
        },
        closedWithoutContractor(){
            if(this.appliedUsers[0] && !this.appliedUsers[0].received_user_id && this.appliedUsers[0].close_flg == 1){
                return true;
            }
        },
        closeRecruitment(){
            if(this.appliedUsers[0] && this.appliedUsers[0].apply_user_id && !this.appliedUsers[0].close_flg == 1){
                return true;
            }
        },
        deleteRecruitment(){
            if(this.appliedUsers[0] && this.appliedUsers[0].apply_user_id && !this.appliedUsers[0].close_flg == 1){
                return true;
            }
        }
    },
    created(){
            this.getAppliedUser();
    }
}
</script>

<style scoped>
.received{
    border: 1px solid red;
}

/* 案件種別表示切替 */
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