<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        用户列表
                  </p>
                  <Row>
                    <Col span="24">
                     <Form :model="formItem" :label-width="80">
                      <Row justify="center" class="code-row-bg">
                        <Col span="6">
                          <FormItem label="手机">
                              <Input v-model="formItem.mobile" placeholder="请输入手机"></Input>
                          </FormItem>
                        </Col>
                        <Col span="6">
                          <FormItem label="邮箱">
                              <Input v-model="formItem.email" placeholder="请输入邮箱"></Input>
                          </FormItem>
                        </Col>
                       <Col span="4">
                          <FormItem label="注册区域">
                            <Select v-model="formItem.country_id" placeholder="请选择">
                                <Option value="">请选择</Option>
                                <Option v-for="item in countryList" :key="item.id" :value="item.id">{{item.name}}</Option>
                            </Select>
                          </FormItem>
                        </Col>
                       <Col span="4">
                          <FormItem label="账户类型">
                            <Select v-model="formItem.account_type" placeholder="请选择">
                                <Option value="">请选择</Option>
                                <Option value="qq">qq</Option>
                                <Option value="wechat">wechat</Option>
                                <Option value="sina">sina</Option>
                                <Option value="mobile">mobile</Option>
                            </Select>
                          </FormItem>
                        </Col>
                        <Col span="8">
                          <FormItem label="注册时间段">
                              <Row>
                                  <Col span="11">
                                      <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="开始" v-model="formItem.datemin"></DatePicker>
                                  </Col>
                                  <Col span="2" style="text-align: center">-</Col>
                                  <Col span="11">
                                      <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="结束" v-model="formItem.datemax"></DatePicker>
                                  </Col>
                              </Row>
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
  import expandRow from './expandRow.vue';
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  import {userListsAction,countryGetAllsAction,userDelAction,userSetSingerAction} from '../../api/api'

  export default {
    components: { expandRow },
    name: 'user-list',
    data () {
      return {
               tableTotal: 20,
               current: 1,
               loading:true,
               columns: [
                  {
                      type: 'expand',
                      width: 30,
                      render: (h, params) => {
                          return h(expandRow, {
                              props: {
                                  row: params.row
                              }
                          })
                      }
                  },
                  {
                      title: 'ID',
                      key: 'id'
                  },
                  {
                      title: '账号',
                      key: 'account_number'
                  },
                  {
                      title: '邮箱',
                      key: 'email'
                  },
                  {
                      title: '区号',
                      key: 'mobile_area_code'
                  },
                  {
                      title: '手机',
                      key: 'mobile'
                  },
                  {
                      title: '账户类型',
                      key: 'account_type'
                  }, 
                  {
                      title: '注册区域',
                      key: 'country_id'
                  },
                  {
                      title: '状态',
                      key: 'status'
                  },
                  {
                      title: '操作',
                      key: 'action',
                      width: 300,
                      align: 'center',
                      render: (h, params) => {
                        return h('div', [
                          h('Button', {
                                style: {
                                    margin: '0 5px'
                                },
                                props: {
                                    type: 'primary',
                                    placement: 'top',
                                    size: 'small'
                                },
                                on: {
                                    click: () => {
                                       this.setSinger(params.row.id)
                                    }
                                }
                          }, '设置为歌手'),
                          /*
                          editButton(
                            ()=>{
                               this.showCreate(params.row.id)
                            },h
                          ),*/
                          deleteButton(()=>{this.remove(params.index,params.row.id)},h)
                        ]);
                      }
                  }
               ],
               data: [],
               searchParam:{},
               formItem: {
                    mobile: '',
                    email:'',
                    country_id:'',
                    account_type:'',
                    datemin:'',
                    datemax:''
               },
               countryList:[]
        }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getDataList()

      //获取所有国家列表
      this.getCountryList()
    },
    methods: {
            //获取数据
            getDataList() {
                this.loading = true
                let param = {
                        page:this.current,
                        mobile:this.searchParam.mobile,
                        email:this.searchParam.email,
                        country_id:this.searchParam.country_id,
                        account_type:this.searchParam.account_type,
                        datemin:this.searchParam.datemin,
                        datemax:this.searchParam.datemax
                    }
                userListsAction(param).then(response => {
                    this.loading = false
                    this.data =  response.data.list;
                    this.tableTotal = response.data.total;
                    console.log(this.data)
                }).catch(function (error) {
                  console.log(error)
                });
            },
            //获取所有数据
            getCountryList() {
                let param = {}
                countryGetAllsAction(param).then(response => {
                    this.countryList =  response.data.list;
                    console.log(this.CountryList)
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
                userDelAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.data.splice(index, 1);
                }).catch(function (error) {
                  this.$Message.info('网络异常，请稍候再试');
                });
            },
            setSinger(id){
                let param = {id:id}
                userSetSingerAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                }).catch(function (error) {
                  this.$Message.info('网络异常，请稍候再试');
                });
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
