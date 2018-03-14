<!--歌手-->
<template>
<div>
        <FormItem label="歌手ID" prop="val">
            <Input v-model="formData.val" placeholder="请输入歌手ID"></Input>
        </FormItem>
</div>
</template>

<script>
  export default {
    name: 'singer',
    data(){
        return{
          formData:{
            val:0
          }
        }
    },
    //创建组件对外提供的事件
    mounted() {
        //对外提供数据
        let _this = this
        this.$on('get-data', function(){
          return _this.formData
        });
        //编辑情况，获取外面数据
        this.$on('init', function(param){
           this.formData = Object.assign({},{
             val:param.val
           })
        });
    },
    methods: {},
    destroyed () {}
  }
</script>


