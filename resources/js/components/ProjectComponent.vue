<template>
    <div class="p-container__listwrap">
        <ProjectList 
        :project="project"
        v-for="project in projects" 
        :key="project.id">
        </ProjectList>
    </div>
</template> 

<script>
import ProjectList from './ProjectListComponent.vue'

export default {
   props: {
       projects:{
           type: Array,
           required: true
       }
   },
   components:{
       ProjectList
   },
}
</script>