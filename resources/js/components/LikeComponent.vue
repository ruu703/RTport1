<template>
    <transition name="like">
        <div class="c-like">
            <div  class="c-like__heart">
                <div :class="{on_heart: isLike, active: isLike, heart_col: isLike}" @click.prevent="heartClick">
                    <i class="far fa-heart"></i>
                </div>
                <div :class="{off_heart: !isLike, active: isLike}" v-if="isLike"  v-cloak>
                    <i class="fas fa-heart heartcol"></i>
                </div>
            </div>   
        </div>      
    </transition> 
</template>

<script>
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
            isLike: '',
            id: '',
            insert: true,
            LikeId: ''
        }
    },
    methods:{
        getLike(){
        // projectテーブルのidを取得
        let id = this.$route.path.substr(9);

        axios.get('/match/api/like', {
            params:{
                projectId: id,
                userId: this.userId
            }
        })
        .then(response => {
        //   console.log(response.data.length)
        const self = this;

        if(response.data.length){
            // console.log('レコードがあります');
            self.LikeId = response.data[0].id;
        }else{
            // console.log('レコードはありません');
            self.LikeId = '';
        }

        if(!response.data.length){
            // console.log('DB に登録がありません')
            self.isLike = false;
            self.insert = false;
        }else if(response.data[0]){
            // console.log('DB にお気に入りがあります');
            // console.log(response.data[0]);

            self.isLike = true;
            self.id = response.data[0].id
        }else if(!response.data[0]){
            // console.log('DB にお気に入りがありません');
            self.isLike = false;
        }
      })
      .catch(error => {
          console.log('エラー発生'.error);
      })
    },
        heartClick(){
            this.isLike = !this.isLike;
            this.remove();
        },
        remove(){
        // console.log(this.insert)
    
        const self = this;
        if(this.insert){
        axios.delete('/match/like/'+this.LikeId)
        .then(function(response){
            self.LikeId = '';
            self.getLike();
        })
        .catch(function(error){
            console.log(error);
        })
        .finally(function(){

        })

        }else{
        
        this.create()

        }
    },
    create(){
        // projectテーブルのidを取得
        let id = this.$route.path.substr(9);
        const self = this;
        axios.post('/match/api/like',{
         project_id: id,
         user_id: this.userId
       }).then(function(response){
        //    console.log(response);
           self.getLike();
       })
       .catch(function(error){
           console.log(error);
       });
       this.insert = true
    }
},
created(){
        this.getLike();
    },
}
</script>

<style lang="stylus" scoped>
[v-cloak] {
  display: none;
}
.heart_col{
    color: rgb(250, 134, 215);
}
.active{
    animation: favPushAnimation .1s ease-out;
}
.on_heart{
    position:absolute;
    
}
.off_heart{
    position:absolute;
    
}


.like-enter, .like-leave-to{
   opacity: 0;
}

.like-leave-active{
    position: absolute;
}
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
@keyframes favPushAnimation{
    from{
        transform: scale(.7);
    }
    to{
        transform: scale(1);
    }
}
</style>