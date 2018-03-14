<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        行为日志列表
                  </p>
   
                  <Row>
                    <Col span="16">
                     <Form :model="formItem" :label-width="80">
                      <Row justify="center" class="code-row-bg">
                       <Col span="4">
                          <FormItem label="用户">
                            <Select v-model="formItem.admin_id" placeholder="请选择">
                                <Option value="">请选择</Option>
                                <Option v-for="item in admins" :key="item.id" :value="item.id">{{item.username}}</Option>
                            </Select>
                          </FormItem>
                        </Col>
                        <Col span="8">
                          <FormItem label="时间段">
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
 
  import {getActionLogListAction,adminGetAllsAction} from '../../api/api'

  export default {
    name: 'action-list',
  
    data () {
      return {
                 tableTotal: 20,
                 current: 1,
                 loading:true,
                 columns: [
                    {
                        title: '编号',
                        key: 'id',
                        width:80
                    },
                    {
                        title: '管理员',
                        key: 'admin_id',
                        width:100
                    },
                    {
                        title: 'IP',
                        key: 'action_ip',
                        width:150
                    },
                    {
                        title: '行为',
                        key: 'title',
                      
                    },
                    {
                        title: '提交数据',
                        key: 'post',
                        
                    },
                    {
                        title: '链接',
                        key: 'log_url',
                        
                    },
                    {
                        title: '时间',
                        key: 'create_time',
                        width:200
                    }
                 ],
                 data: [],
                 searchParam:{},
                 formItem: {
                    admin_id: '',
                    datemin:'',
                    datemax:''
                 },
                 admins:[]
        }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getDataList()
      //获取所有管理员
      this.getAdmins()
    },
    methods: {
            //获取数据
            getDataList() {
                this.loading = true
                let param = {
                        page:this.current,
                        admin_id:this.searchParam.admin_id,
                        datemin:this.searchParam.datemin,
                        datemax:this.searchParam.datemax
                    }
                getActionLogListAction(param).then(response => {
                    this.loading = false
                    this.data =  response.data.list;
                    this.tableTotal = response.data.total;
                    console.log(this.data)
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
            //获取所有语言
            getAdmins(){
                    let param = {}
                    adminGetAllsAction(param).then(response => {
                        this.admins = response.data.list 
                    }).catch(function (error) {
                      console.log(error)
                    });
            },

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
