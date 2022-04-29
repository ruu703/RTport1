<template>
    <span class="c-counter">
        {{ textCount }}/1000
    </span>
</template>

<script>
export default {
    props:['textLength'],
    computed:{
        // 文字数カウント
        textCount: function() {

        var text = this.textLength;

        if(text == null){
            text = 0;
        }

        return text.length
      }
    }
}
</script>