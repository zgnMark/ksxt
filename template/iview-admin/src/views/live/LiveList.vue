<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        直播列表
                  </p>
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
 
  import {liveListsAction,liveDelAction} from '../../api/api'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'live-lists',
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
                      title: '歌曲名称',
                      key: 'title'
                  },
                  {
                      title: '封面图',
                      key: 'cover_picture'
                  },
                  {
                      title: '直播内容',
                      key: 'content'
                  },
                  {
                      title: '最高在线数',
                      key: 'online_num'
                  },
                  {
                      title: '开始时间',
                      key: 'start_time'
                  },
                  {
                      title: '结束时间',
                      key: 'end_time'
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
                        deleteButton(()=>{this.remove(params.index,params.row.id)},h)
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
                liveListsAction(param).then(response => {
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

            remove (index,id) {
                let param = {id:id}
                liveDelAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.data.splice(index, 1);
                }).catch(function (error) {
                  this.$Message.info('删除失败');
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
