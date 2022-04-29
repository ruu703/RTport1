<template>
    <div v-if="board.message">
        <!-- 取引相手のメッセージ -->
        <div class="p-user" v-if="board.send_user && board.send_user == partnerUserInfo.id">
            <div class="p-user__img p-user__img--message">
                <img :src='"https://ruka.sakura.ne.jp/match/"+partnerUserInfo.profile_img' alt="プロフィール画像" class="p-user__avator p-user__avator--message">
            </div>
            <div class="p-user__wrap p-user__wrap--directmessage">
                <div class="p-user__profile">
                    <span class="p-user__nickname">
                        {{ partnerUserInfo.nickname }}
                    </span>
                    <span class="c-badge" v-if="board.order_user_id == partnerUserInfo.id">
                        発注者
                    </span>
                </div>
                <div class="p-user__message p-user__message--direct">
                    <span>
                        {{ board.message }}
                    </span>
                </div>
                <span class="p-user__time p-user__time--left">
                {{ time }}
                </span>
            </div>
        </div>

        <!-- 自分のメッセージ -->
        <div class="p-user p-user--right p-user--message" v-else>
            <div class="p-user__img p-user__img--message">
                <img :src='"https://ruka.sakura.ne.jp/match/"+myUserInfo.profile_img' alt="プロフィール画像" class="p-user__avator p-user__avator--message">
            </div>
            <div class="p-user__wrap p-user__wrap--directmessage">
                <div class="p-user__profile p-user__profile--right">
                    <span class="p-user__nickname">
                        {{ myUserInfo.nickname }}
                    </span>
                    <span class="c-badge" v-if="board.order_user_id == myUserInfo.id">
                        発注者
                    </span>
                </div>
                <div class="p-user__message">
                    <span>
                        {{ board.message }}
                    </span>
                </div>
                <span class="p-user__time">
                {{ time }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['board', 'partnerUserInfo', 'myUserInfo'],
    data(){
        return{
            time: ''
        }
    },
    methods: {
        // メッセージ投稿からの経過時間を表示
        elapsedTime(){
            let from = new Date(this.board.created_at);
            let to = new Date();

            // 経過時間をミリ秒で取得
            let ms = to.getTime() - from.getTime();
            // ミリ秒を分数に変換(端数切捨て)
            let min = Math.floor(ms / (1000*60));
            // ミリ秒を時間に変換(端数切捨て)
            let hour = Math.floor(ms / (1000*60*60));
            // ミリ秒を日付に変換(端数切捨て)
            let days = Math.floor(ms / (1000*60*60*24));

            if(days > 30){
             this.time = '1ヶ月以上前';
            }else if(days > 0){
             this.time = days+'日前'; 
            }else if(hour > 0){
             this.time = hour+'時間前'; 
            }else if(min > 0){
             this.time = min+'分前';
            }
        }
    },
    created(){
        this.elapsedTime()
        // console.log(this.time);
    },
}
</script>