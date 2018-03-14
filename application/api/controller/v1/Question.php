<?php
namespace app\api\controller\v1;

use app\vendor\log\Monolog;
use think\Db;
use think\Loader;
class Question extends Base
{
    /**
     * 列表
     * @return [type] [description]
     */
    public function lists()
    {

        $room_id    = input('param.room_id', 1);
        $userid     = input('param.userid','');

/*        $data = Db::table('x2_examhistory')->where(['status'=>0,'user_id'=>$userid])->find();
        if (!empty($data)) {
            return $this->packReturn([
                'code'    => 100,
                'data'    => $data,
            ]);
        }*/
        if (empty($room_id)||empty($userid)) {
            return 'id不能为空';
        }
        $id = Db::table('x2_examhistory')->insertGetId([
            'status'=>0,
            'user_id'=>$userid,
            'room_id'=>$room_id, 
            'start_time'=>date('Y-m-d H:i:s',time())
        ]);
        $param = [
            'room_id'=> $room_id,
            'is_del' => 0,
        ];
        //获取题目列表
        $multiData = Loader::model('MultiQuestion', 'logic')->getRandList($param);
        $singleData = Loader::model('SingleQuestion', 'logic')->getRandList($param);


        array_walk($multiData, function (&$v) {
            $v['answer'] = explode(',',$v['answer']);
        });

        $room = Db::table('x2_examroom')->where(['id'=>$room_id])->value('title');
        $count =  count(array_merge($singleData,$multiData));

        return $this->packReturn([
            'paper_id'=>$id,
            'code'    => 0,
            'list'     => array_merge($singleData,$multiData),
            'room'    => $room,
            'total'   => $count,
        ]);
    }    

    /**
     * 交卷
     * @return [type] [description]
     */
    public function commit()
    {
        try{
            $paper_id     = input('param.paper_id', '');
            $score        = input('param.score', '');
            $end_time     = date('Y-m-d H:i:s',time());
            $error_num     = input('param.error_num', '');
            $right_num     = input('param.right_num', '');
            $list_time     = input('param.list_time', '');
            $list_time     = 45-intval(explode(':',$list_time)[1]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        if (empty($paper_id)) {
            return 'id不能为空';
        }
        $status = Db::table('x2_examhistory')->where(['id' => $paper_id])->value('status');
        
        if ($status == 1) {
            return $this->packReturn([
                'code'    => 100,
                'msg'     => '你TM已经交过卷了',
            ]);
        }
        $param = [
            'score'     => $score,
            'end_time'  => $end_time,
            'list_time'  => $list_time,
            'error_num' => $error_num,
            'right_num' => $right_num,
            'status'    => 1,
        ];
        $flag = Db::table('x2_examhistory')->where(['id' =>$paper_id])->update($param);

        $flag ? $code = 0:$code = 100;
        
        return $this->packReturn([
            'code'    => $code,
        ]);
    }    
    /**
     * 下一题
     * @return [type] [description]
     */
    public function confirm()
    {
        $paper_id      = input('param.paper_id', '');
        $question_id   = input('param.question_id', '');
        $end_time      = date('Y-m-d H:i:s',time());
        $score         = input('param.score', '');
        $error_num     = input('param.error_num', '');
        $right_num     = input('param.right_num', '');
        $check         = input('param.check', '');
        $list_time     = input('param.list_time', '');
        $num           = input('param.num','');

/*       return $this->packReturn([
            'code'    => $question_id,
            'codes'    => $_POST['check'][0],
        ]);*/


        if (empty($question_id) || empty($paper_id)) {
            return $this->packReturn([
                'msg'     => 'id不能为空',
                'code'    => 0,
            ]);
        }
        $param = [
            'id'        => $paper_id,
            'score'     => $score,
            'error_num' => $error_num,
            'right_num' => $right_num,
            'end_time'  => $end_time,
            'num'       => $num,
            'status'    => 0,
        ];
        $flag = Db::table('x2_examhistory')->where(['id' =>$paper_id])->update($param);
        $flag? $code = 0 : $code =100;

/*        return $this->packReturn([
            'msg'     => '检测成功',
            'code'    => $check,
        ]);*/
        $answer = explode(',',Db::table('x2_question')->where(['id'=>$question_id])->value('answer'));
        return $this->packReturn([
            'msg'     => '检测成功',
            'code'    => $this->check($answer,str_split($check)),
        ]);
    }

    public function continue()
    {
        $userid  = input('param.userid','');
        $room_id  = input('param.room_id','');

        if (empty($userid) && empty($room_id)) {
            return $this->packReturn([
                'code'             => 100,
                'msg'             => 'id不能为空',
            ]);
        }
        $history_data = Db::table('x2_examhistory')->where(['status'=>0,'user_id'=>$userid,'room_id'=>$room_id])->find();        
        if (empty($history_data)) {
            return $this->packReturn([
                'code'             => 100,
                'msg'             => '没有上次考试记录',
        ]);
        }
        $num = 50 - $history_data['num'];
        if ($num>10) {
            $data = Db::table('x2_question')->limit($num)->order('rand()')->select();
        } else {
            $data = Db::table('x2_question')->limit($num)->order('rand()')->select();
        }
        return $this->packReturn([
            'code'    => 0,
            'msg'             => '检测成功',
            'history_data'    => $history_data,
            'list'            => $data,
            'total'           => $num,
        ]);
    }

    private function check($answer, $data)
    {
        $x =  array_diff($answer,$data);
        $y =  array_diff($data,$answer);

        if (empty($x) && empty($y)) {
            return 1;
        } else {
            return 0;
        }

    }

    public function test()
    {
        $arr = [1,2];
        $data = explode(',',Db::table('x2_question')->where(['id'=>11])->value('answer'));

        $x =  array_diff($arr,$data);
        if (empty($x)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function uu()
    {
        $userid  = input('param.userid','');
        $room_id  = input('param.room_id','');
        $flag = Db::table('x2_examhistory')->where(['status'=>0,'user_id'=>$userid,'room_id'=>$room_id])->update(['status'=>2]);
    }

}
