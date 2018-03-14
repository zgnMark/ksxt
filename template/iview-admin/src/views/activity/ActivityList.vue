<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        活动列表
                  </p>
                  <Row>
                    <Col span="24">
                     <Form :model="formItem" :label-width="80">
                      <Row justify="center" class="code-row-bg">
                        <Col span="2">
                          <Button type="primary" shape="circle" class="btn" icon="plus-round" @click="showCreate()">新增</Button>
                        </Col>
                        <Col span="6">
                          <FormItem label="标题">
                              <Input v-model="formItem.title" placeholder="请输入标题"></Input>
                          </FormItem>
                        </Col>
                       <Col span="4">
                          <FormItem label="语言">
                            <Select v-model="formItem.language_id" placeholder="请选择">
                                <Option value="">请选择</Option>
                                <Option v-for="item in languages" :key="item.id" :value="item.id">{{item.name}}</Option>
                            </Select>
                          </FormItem>
                        </Col>
                       <Col span="4">
                          <FormItem label="举办国家">
                            <Select v-model="formItem.country_id" placeholder="请选择">
                                <Option value="">请选择</Option>
                                <Option v-for="item in countryList" :key="item.id" :value="item.id">{{item.name}}</Option>
                            </Select>
                          </FormItem>
                        </Col>

                        <Col span="2">
                          <FormItem>
                              <Button type="primary" v-on:click="search">搜索</Button>
                          </FormItem>
                        </Col>
                      </Row>
                     </Form>
                    </Col>
                  </Row>
                  <Row>
                    <Col span="24" class="main-inner-content">
                      <Table stripe :columns="columns" :data="data"></Table>
                    </Col>
                  </Row>
                  <Row>
                    <Col span="24" class="pages">
                    <Page :total="tableTotal" :page-size="20" :current="1" @on-change="changePage" show-elevator></Page>
                    </Col>
                  </Row>
              </Card>
            </Col>
        </Row>

  
</template>

<script>

  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  import {base} from '../../api/index'
  import {activityListsAction,languageGetAllsAction,countryGetAllsAction,activityDelAction} from '../../api/api'

  export default {
    name: 'activity-list',
    data () {
      return {
               tableTotal: 20,
               current: 1,
               loading:true,
               columns: [
                  {
                      title: 'ID',
                      key: 'id',
                      width:50
                  },
                  {
                      title: '标题',
                      key: 'title'
                  },
                  {
                      title: '封面图',
                      key: 'cover_img',
                      render: (h, params) => {
                          if(params.row.cover_img != ''){
                                return h('Img', {
                                  attrs:{
                                    'src':base + params.row.cover_img
                                  },
                                  style: {
                                    width: '100px',
                                    'margin-top':'5px',
                                    height:'100px'
                                  }
                                })
                          }else{
                               return 'null'
                          }
                      }
                  },
                  {
                      title: '语言',
                      key: 'language_id'
                  },
                  {
                      title: '举办国家',
                      key: 'country_id'
                  },
                  {
                      title: '举办时间',
                      key: 'start_time',
                      render: (h, params) => {
                        return params.row.start_time + " - " + params.row.end_time
                      }
                  },
                  {
                      title: '详细地址',
                      key: 'address'
                  },
                  {
                      title: '创建者',
                      key: 'admin_id'
                  },
                  {
                      title: '查看数',
                      key: 'view_num'
                  }, 
                  {
                      title: '状态',
                      key: 'status',
                      width:60
                  },
                  {
                      title: '操作',
                      key: 'action',
                      width: 300,
                      align: 'center',
                      render: (h, params) => {
                        return h('div', [
                          editButton(
                            ()=>{
                               this.showCreate(params.row.id)
                            },h
                          ),
                          deleteButton(()=>{this.remove(params.index,params.row.id)},h)
                        ]);
                      }
                  }
               ],
               data: [],
               searchParam:{},
               formItem: {
                    title: '',
                    language_id:'',
                    country_id:''
               },
               //所有国家
               countryList:[],
               //所有语言
               languages:[]
      }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getDataList()
      //获取所有国家列表
      this.getCountrys() 
      //获取所有语言列表
      this.getLanguages()
    },
    methods: {
            //获取数据
            getDataList() {
                this.loading = true
                let param = {
                        page:this.current,
                        title: this.searchParam.title,
                        language_id:this.searchParam.language_id,
                        country_id:this.searchParam.country_id,
                    }
                activityListsAction(param).then(response => {
                    this.loading = false
                    this.data =  response.data.list;
                    this.tableTotal = response.data.total;
                    console.log(this.data)
                }).catch(function (error) {
                  console.log(error)
                });
            },

            //获取所有语言
            getLanguages(){
                    let param = {}
                    languageGetAllsAction(param).then(response => {
                        this.languages = response.data.list 
                    }).catch(function (error) {
                      console.log(error)
                    });
            },
            //获取所有国家
            getCountrys(){
                    let param = {}
                    countryGetAllsAction(param).then(response => {
                        this.countryList = response.data.list 
                    }).catch(function (error) {
                      console.log(error)
                    });
            },

            changePage (page) {
                console.log(page)
                this.current = page
                this.data = this.getDataList();
            },
            search (){
                this.searchParam = this.formItem
                this.current = 1
                this.getDataList()
            },
            remove (index,id) {
                let param = {id:id}
                activityDelAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.data.splice(index, 1);
                }).catch(function (error) {
                  this.$Message.info('网络异常，请稍候再试');
                });
            },
            showCreate(id){
              if(id > 0){
                this.$router.push({
                                   name: 'activity-publish',
                                   params: { id: id }
                                 });
              }else{
                this.$router.push({ name: 'activity-publish', params: { id: id }})
                                  }
              
            }
    }
  }
</script>

<style scope>

  .top {
    margin-top: 15px
  }



  .pages {
    text-align: right;
    margin-top: 10px;
    padding-right: 10px;
  }

  .form {
    margin-right: 20px;
  }

  .be-inline-block {
    /*display: inline-block;*/
    /*line-height: 50px;*/
    vertical-align: middle;
  }
  .button-warp{
   /* margin-bottom: 15px;*/
  }
  .be-inline-block .btn{
    margin-right: 15px;
  }

  .be-inline-block  .searth-input .ivu-input{
    border-radius: 32px;
  }
</style>
