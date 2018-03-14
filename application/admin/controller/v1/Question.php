<?php
namespace app\admin\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
use PHPExcel_IOFactory;
use PHPExcel;



class Question extends Common
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {
        $page       = input('param.page', 1);
        $pageSize   = input('param.pageSize', 20);
        $order      = input('param.order', 'desc');
        $orderField = input('param.order_field', 'id');

        $id     = input('param.id');
        $is_del  = input('param.is_del', '');
        $room_id = input('param.room_id', '');
        $question = input('param.question', '');
        $optionA = input('param.optionA', '');
        $optionB = input('param.optionB', '');
        $optionC = input('param.optionC', '');
        $optionD = input('param.optionD', '');
        $answer = input('param.answer', '');

        $orderSort = [
            'order'       => $order,
            'order_field' => $orderField,
        ];
        $param = [
            'id'      => $id,
            'is_del'  => $is_del,
            'optionA' => $optionA,
            'optionB' => $optionB,
            'optionC' => $optionC,
            'optionD' => $optionD,
            'answer'  => $answer,
            'question'  => $question,
            'room_id' => $room_id,
        ];
        //获取题目列表
        $data = Loader::model('MultiQuestion', 'logic')->getList(array_merge($param, ['page' => $page, 'pageSize' => $pageSize]), $orderSort);
        //获取用户详细信息
        $ids      = array_column($data['list'], 'room_id');
        $roomData = Db::table('x2_examroom')->where(['id' => ['in', $ids]])->select();
        $roomData = array_column($roomData, null, 'id');



       //转换
        array_walk($data['list'], function (&$v) use ($roomData) {
            $v['room_title'] = $roomData[$v['room_id']]['title'];
        });


        return $this->packReturn([
            'code'    => 0,
            'list'    => $data,
        ]);
    }

    public function save()
    {
        $id          = input('param.id', '');
        $optionA     = input('param.optionA', '');
        $optionB     = input('param.optionB', '');
        $optionC     = input('param.optionC', '');
        $optionD     = input('param.optionD', '');
        $answer      = input('param.answer', '');
        $room_id     = input('param.room_id', '');
        $is_del      = input('param.is_del', '');

        if(!is_numeric($answer)){
            return $this->packReturn([
                'code' => 100,
                'msg'  => '答案上传数字',
            ]);
        }    

        $flag = Db::table('x2_question')->where(['room_id' => $room_id])->find();
        if (!$flag) {
            return $this->packReturn([
                'code' => 100,
                'msg'  => '请在现有考场中获取数据',
                'data' => $flag,
            ]);
        }
/*        $room_data = Db::table('x2_examroom')->select();    
        $ids      = array_column($data['list'], 'room_id');*/
        $params = [
            'optionA'     => $optionA,
            'optionB'     => $optionB,
            'optionC'     => $optionC,
            'optionD'     => $optionD,
            'answer'      => $answer,
            'room_id'     => $room_id,
            'is_del'      => $is_del,
        ];
        if (empty($id)) {
            $data = Db::table('x2_question')->insert($params);
        } else {
            $data = Db::table('x2_question')->where($id)->save($params);
        }
       
        if (empty($data)) {
            return $this->packReturn([
                'code' => 100,
                'msg'  => empty($id) ? '创建失败' : '编辑失败',
            ]);
        }
        $data = Db::table('x2_examroom')->where(['id'=>$room_id])->find();
        if (!empty($data)) {
            $news = $data['title'].'题目已更新';
            $this->addNews($news,$data['subject_id']);  
        }
        return $this->packReturn([
            'code' => 0,
            'msg'  => empty($id) ? '创建成功' : '编辑成功',
        ]);
    }


    public function excel()
    {
        $room_id          = input('param.room_id', 1);
/*        $question_type    = input('param.type', 'x2_multiques');*/
        $count            = 0;
        $msg              = [];

        //import('phpexcel.PHPExcel', EXTEND_PATH);//方法二  
        //vendor("PHPExcel.PHPExcel"); //方法一  
        $objPHPExcel = new \PHPExcel();  
  
        //获取表单上传文件  
        
        $file = request()->file('excel');  
        if (empty($file)) {
            return '文件传输失败';
        }
        try{
            $info = $file->validate(['size'=>156782132,'ext'=>'xlsx,xls,csv'])->move(ROOT_PATH . 'public' . DS . 'excel');  
        } catch (\Exception $e) {
            Monolog::error('上传失败,[Admin.question.excel]:' . $e->getMessage(), []);
            return $this->packReturn([
                'code' => 100,
                'msg'  => '上传失败'.$e->getMessage(),
            ]);
        }
        if($info){  
            $exclePath = $info->getSaveName();  //获取文件名  
            $extension = $info->getExtension();
            $file_name = ROOT_PATH . 'public' . DS . 'excel' . DS . $exclePath;   //上传文件的地址  
            $objReader =\PHPExcel_IOFactory::createReader('Excel2007');

            switch ($extension) {
                case 'xlsx':
                    $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
                    break;
                case 'xls':
                    $objReader =\PHPExcel_IOFactory::createReader('Excel5');
                    break;
                case 'csv':
                    $objReader =\PHPExcel_IOFactory::createReader('CSV');
                    break;
                default:    
                    break;
            }
            $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8  
            //return var_export($obj_PHPExcel);
            $excel_array  = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
/*            if ($excel_array[0][0] != '1') {
                return 'xls的考试文件格式不正确';
            }*/
            array_shift($excel_array); 
            $count = 0; 
            foreach ($excel_array as $key => $value) {
                $data = [
                    'room_id' => $room_id,
                    'question'=> $value[0],
                    'optionA' => $value[1],
                    'optionB' => $value[2],
                    'optionC' => $value[3],
                    'optionD' => $value[4],
                    'answer'  => $value[5],
                    'type'    => $value[8],
                ];

                $flag = Db::table('x2_question')->where($data)->find();

                if ($flag) {
                    $msg[] = '第'.++$key.'道题目已存在';
                } else {
                  $id = Db::table('x2_question')->insert($data);
                  $id ? $count++ : $msg[] ='第'.++$key.'道题目插入失败';
                }
            }

        }   
        $data = Db::table('x2_examroom')->where(['id'=>$room_id])->find();
        if (!empty($data)) {
            $news = $data['title'].'题目已更新';
            $this->addNews($news,$data['subject_id']);  
        }   
        return $this->packReturn([
            'code'  => 0,
            'count' => $count,
            'msg'   => $msg,
        ]);
    }


