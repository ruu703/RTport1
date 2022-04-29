import Vue from 'vue'
import Router from 'vue-router'
import Project from './components/ProjectComponent.vue'
import PublicMessage from './components/PublicMessageComponent.vue'
import Like from './components/LikeComponent.vue'
import AppliedUser from './components/AppliedUserComponent.vue'
import AddProject from './components/FormProjectAddComponent.vue'
import EditProject from './components/FormProjectEditComponent.vue'
import Addprofile from './components/FormProfileAddComponent.vue'
import Directmessage from './components/DirectMessageComponent.vue'
import SearchProject from './components/SearchProjectComponent.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: '/match',
  routes: [
       {// TOPページ新着一覧
        path: '/',
        name: 'newproject',
        component: Project
       },
       { // 新規案件登録フォーム
        path: '/projectform',
        name: 'addproject',
        component: AddProject
       },
       { // 案件編集フォーム
        path: '/projectform/:id',
        name: 'edit',
        component: EditProject
      },
      { // ダイレクトメッセージページ
        path: '/message/:id',
        name: 'addmessage',
        component: Directmessage
      },
      { // プロフィール編集フォーム
        path: '/profileform',
        name: 'addprofile',
        component: Addprofile
      },
      { // プロフィールページ
        path: '/profile/:id',
        name: 'profile',
        component: Project
      },
      { // 案件詳細ページ内パブリックメッセージ
        path: '/project/:id',
        name: 'project',
        components: {
          default: PublicMessage,
          Like,
          AppliedUser

        }
      },
      {
        path: '/search',
        name: 'search',
        component: SearchProject
      }
  ]
});