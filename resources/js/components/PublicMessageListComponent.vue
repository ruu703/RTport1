<template>
    <div class="p-user">
        <div class="p-user__img p-user__img--message">
            <img :src='"https://ruka.sakura.ne.jp/match/"+imgurl' alt="プロフィール画像" class="p-user__avator p-user__avator--message">
        </div>
        <div class="p-user__wrap">
            <div class="p-user__profile">
                <span class="p-user__nickname">
                    {{ message.user.nickname }}
                </span>
                <span class="c-badge" v-if="project.order_user_id == message.user_id">
                    発注者
                </span>
            </div>
            <div class="p-user__message">
                <span>
                    {{ message.message }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['message', 'project'],
    data(){
        return{
            imgurl : this.message.user.profile_img,
        }
    }
}
</script>