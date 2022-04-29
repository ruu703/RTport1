<template>
    <div class="p-container__panel p-container__panel--small">
        <a :href="url+project.id">
            <span class="p-container__tag">
                {{ project.category.category_name }}
            </span>
            <div class="p-container__inner">
                <h3>
                    {{ project.title | omittedText}}
                </h3>
                <p>
                    {{ project.detail | omittedText}}
                </p>
                <div v-if="project.category_id === 1">
                    報酬
                </div>
                <div v-else>
                    収益分配率
                </div>
                <span class="p-container__reward">
                    {{ project.fee_low | priceLocaleString}}
                        〜
                    {{ project.fee_high | priceLocaleString}}
                    <span v-if="project.category_id === 1">
                    円
                    </span>
                    <span v-else>
                    %
                    </span>
                </span>
            </div>
        </a>
    </div>
</template>

<script>
export default {
        props:['project'],
        filters:{
           priceLocaleString(value) {
               // 3桁毎に,を入れる
　              return value.toLocaleString();
            },
            omittedText(text) {
                // 30文字目以降は"…"
                return text.length > 50 ? text.slice(0, 50) + "…" : text;
    } 
        },
        data(){
            return{
            url: '/match/project/',
        }
    }
}
</script>