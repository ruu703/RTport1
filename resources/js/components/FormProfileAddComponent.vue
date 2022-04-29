<template>
    <div>
        <div v-if="!formSent">
            <label for="profile_img" class="c-label">
                プロフィール画像
            </label>
            <div class="p-user__img u-wrap">
                <div @dragenter="dragEnter" @dragleave="dragLeave" @drop="dropFile"
                    class="c-form--droparea" :class="{ dotted : enter }">
                    <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png"
                        class="c-form--file"
                        ref="file" @change="setFile" multiple>
                        
                    <img :src="preview_img" alt="プロフィール画像" 
                        class="p-user__avator p-user__avator--edit" v-if="preview_img !== null">

                    <img :src="'https://ruka.sakura.ne.jp/match/'+user.profile_img" alt="プロフィール画像" v-else-if="preview_img == null"
                        class="p-user__avator p-user__avator--edit">
                </div>
            </div>
            <span class="c-errormsg" role="alert" v-html="errors.file">
            </span>

            <label for="nickname" class="c-label">
                ニックネーム
            </label>
            <input type="text" name="word" class="c-form c-form--input" id="nickname"  :value="user.nickname" @input="setUser({'nickname':$event.target.value})">
            <span class="c-errormsg" role="alert" v-html="errors.nickname">
            </span>

            <label for="email" class="c-label">
                メールアドレス
            </label>
            <input type="email" name="email" class="c-form  c-form--input" id="email" :value="user.email" @input="setUser({'email': $event.target.value})">
            <span class="c-errormsg" role="alert" v-html="errors.email">
            </span>

            <label for="introduction" class="c-label">
                自己紹介文
            </label>
            <textarea class="c-form c-form--textarea" rows="5" id="introduction" :value="user.introduction" @input="setUser({'introduction': $event.target.value})">
            </textarea>
                
            <span class="c-errormsg" role="alert" v-html="errors.introduction">
            </span>
                
            <TextCount :text-length="user.introduction"></TextCount>

            <div class="p-container__btnwrap">
                <button class="c-btn p-container__submit p-container__submit--black" @click.prevent="postUser">
                    登録
                </button>
            </div>  
        </div> 

        <div v-else class="p-container__posted">
            <p class="u-margin--l u-font--size-m">
            {{ message }}
            </p>
        
        <div class="u-margin--l">
            <a href="https://ruka.sakura.ne.jp/match/mypage">マイページへ戻る</a>
        </div>
        </div>
    </div>
</template>

<script>
import { mapState,mapMutations,mapGetters,mapActions } from 'vuex'
import TextCount from './TextCountComponent.vue'

export default {
    props: {
        userObj:{
           type: Object,
           required: true 
        }
    },
    components:{
        TextCount
    },
    computed:{
        ...mapGetters(['user', 'preview_img', 'errors', 'enter', 'files', 'formSent', 'message'])
    },
    methods:{
        ...mapActions(['setUser','updateNickname', 'updateEmail', 'updateIntroduction', 'updateImg',
                        'setErrors', 'isEnter', 'setFiles', 'setFormSent', 'setMessage', 'updateUser']),
        //　画像ドロップ時のCSS
        dragEnter() {
            this.isEnter(true);
        },
        dragLeave() {
            this.isEnter(false);
        },
        dropFile()  {
            this.isEnter(true);
        },
        // 画像プレビュー & filesにセット
        setFile(e){
            this.isEnter(false);
            this.setFiles(e.target.files[0])
            this.validFile();
        },
        // ファイルバリデーション
        validFile(){

            this.setErrors({'file':''});

            if (!this.files.type.match("image.*")) {
                this.setErrors({'file':'画像を選択してください。'});
            }else{
                //　画像ファイルであればプレビュー表示する
                this.updateImg(URL.createObjectURL(this.files));
            }
            
            //　最大ファイルサイズ
            const maxSize = 1024 * 1024 * 1;

            if (this.files.size >= maxSize){
                this.setErrors({'file':'ファイルサイズは1MB以下にしてください。'});
            }

        },
        postUser(){

            const formData = new FormData()

            // フォームのデータをセット
            formData.append('file', this.files)
            formData.append('id', this.user.id)
            formData.append('nickname', this.user.nickname)
            formData.append('email', this.user.email)
            formData.append('introduction', this.user.introduction)

            this.setErrors({});
            this.updateUser(formData);

            // プレビュー画像データ削除
            URL.revokeObjectURL(this.preview_img);
            // this.setUser();
        }
    },
    created(){
        // propsで受け取ったユーザーデータをVuexのstateにセットする
        this.setUser(this.userObj);
    }
    
}
</script>

<style scoped>
.dotted {
    border: 3px dotted #dadada;
    opacity: 0.7;
    /* width: 206px;
    height: 206px; */
    border-radius: 100px;
    justify-content: center;
}
</style>