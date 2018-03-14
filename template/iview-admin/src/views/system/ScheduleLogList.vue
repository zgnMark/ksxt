<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        执行日志列表
                  </p>
                  <Row>
                    <Col span="16">
                     <Form :model="formItem" :label-width="80">
                      <Row justify="center" class="code-row-bg">
                        <Col span="6">
                          <FormItem label="标准输出：">
                              <Input v-model="formItem.standard_output" placeholder="请输入信息"></Input>
                          </FormItem>
                        </Col>
                        <Col span="6">
                          <FormItem label="异常输出：">
                              <Input v-model="formItem.error_output" placeholder="请输入信息"></Input>
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
                              <Button type="primary" v-on:click="search">搜索日志</Button>
                          </FormItem>
                        </Col></Row>
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
 
  import {getScheduleLogListAction} from '../../api/api'

  export default {
    name: 'schedule-log-list',
    data () {
      return {
               tableTotal: 20,
               current: 1,
               loading:true,
               columns: [
                  {
                      title: '编号',
                      key: 'id',
                      width:100
                  },
                  {
                      title: '任务ID',
                      key: 'schedule_id',
                      width:100
                  },
                  {
                      title: '开始执行',
                      key: 'start_time',
                      width:180
                  },
                  {
                      title: '结束执行',
                      key: 'end_time',
                      width:180
                  },
                  {
                      title: '标准输出',
                      key: 'standard_output',
                      
                  },
                  {
                      title: '异常输出',
                      key: 'error_output',
                      
                  },
                  {
                      title: '运行状态',
                      key: 'run_status',
                      width:100,
                      render: (h, params) => {
                        switch (params.row.run_status){
                            case '1': return '运行中';
                            case '2': return '执行成功';
                            case '3': return '执行失败';
                            default :return '执行成功';
                        }
                      }
                  }
               ],
               data: [],
               formItem: {
                  id:0,
                  standard_output: '',
                  error_output:'',
                  datemin:'',
                  datemax:''
               }
      }
    },
    //加载完成自动执行
    mounted() {
      let id ;
      if(this.$route.params.id <= 0 || this.$route.params.id == undefined) {
         id = localStorage.getItem('schedule_log_id')
      }else{
         localStorage.setItem('schedule_log_id',this.$route.params.id)
         id = this.$route.params.id
      }
      //初始化id
      this.formItem.id=id
      //获取列表数据
      this.getDataList()
    },
    methods: {
            //获取数据
            getDataList() {
                this.loading = true
                let param = {
                        page:this.current,
                        id:this.formItem.id,
                        standard_output:this.formItem.standard_output,
                        error_output:this.formItem.error_output,
                        datemin:this.formItem.datemin,
                        datemax:this.formItem.datemax
                    }
                getScheduleLogListAction(param).then(response => {
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
                this.current = 1
                this.getDataList()
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
</style>
