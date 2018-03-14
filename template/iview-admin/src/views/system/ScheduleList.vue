<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        定时计划列表
                  </p>
   
                  <Row>
                    <Col span="16">
                      <Row   justify="center" align="bottom" style="margin-bottom:15px;" >
                        <Col span="3">
                            <Button type="primary" shape="circle" class="btn" icon="plus-round" @click="showCreate()">新增</Button>
                        </Col>
                      </Row>
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
 
  import {getScheduleListAction} from '../../api/api'

  export default {
    name: 'schedule-list',
  
    data () {
      return {
               tableTotal: 20,
               current: 1,
               loading:true,
               columns: [
                  {
                      title: '执行时间',
                      key: 'expression',
                      width:150
                  },
                  {
                      title: '执行表达式',
                      key: 'command',
              
                  },
                  {
                      title: '备注',
                      key: 'remarks',
                 
                  },
                  {
                      title: '锁定状态',
                      key: 'locked',
                      width:100,
                      render: (h, params) => {
                         return params.row.locked== 1?'锁定':'正常'
                      }
                  },
                  {
                      title: '状态',
                      key: 'status',
                      width:100,
                      render: (h, params) => {
                         return params.row.status== 1?'已上线':'下线'
                      }
                  },
                  {
                      title: '操作',
                      key: 'action',
                      width: 300,
                      align: 'center',
                      render: (h, params) => {
                        return h('div', [
                          h('Button', {
                            props: {
                              type: 'primary',
                              icon:"ios-eye",
                              size: 'small'
                            },
                            style: {
                              marginRight: '5px'
                            },
                            on: {
                              click: () => {
                                this.$router.push({ name: 'system-schedule-log-list', params: { id: params.row.id }})
                              }
                            }
                          }, '查看执行日志'),
                        ]);
                      }
                    }
               ],
               data: []
      }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getDataList()
    },
    methods: {
        //获取数据
        getDataList() {
            this.loading = true
            let param = {
                    page:this.current
                }
            getScheduleListAction(param).then(response => {
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
