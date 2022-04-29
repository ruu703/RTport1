<template>
    <div>     
        <div class="p-container__listwrap">
            <SearchProjectList  
            :project="project"
            v-for="project in projects.data" 
            :key="project.id">
            </SearchProjectList>    
        </div>
    </div>
</template>

<script>
import SearchProjectList from './SearchProjectListComponent.vue'

export default {
    props: {
        projects:{
            type: Object,
            required: true
        }
    },
   components:{
       SearchProjectList,
   },
}
</script>