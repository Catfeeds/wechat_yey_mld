<?php
/*
 * 修正报名平台状态为允许信息核验但是信息没有同步到本地的问题
 */
ignore_user_abort(true);//在关闭连接后，继续运行php脚本
ini_set("max_execution_time",1800);
set_time_limit(300);
define('RELATIVITY_PATH', '../../'); //定义相对路径
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/admission/include/ajax_operate.class.php';
$o_operate = new Operate_Admission();
$o_base=new Bn_Basic();
//读取没有同步本地的数据
$o_stu=new Student_Info();
$o_stu->PushWhere ( array ('&&', 'Name', '=', '') );
for($i=0;$i<$o_stu->getAllCount();$i++)
{
    $s_url=$o_operate->S_Url.'get_signup_info_single.php';
    $a_data=array(
        'license'=>$o_operate->S_License,
        'state'=>3, // 1：等待确认信息核验，2：不允许信息核验，3：允许信息核验:4：核验不通过:5：核验通过等待录取:6：补录取:7：已录取等待分班
        'key'=>$o_stu->getStudentId($i)
    );
    $s_result=$o_base->httpsRequest($s_url,$a_data);
    $a_result=json_decode($s_result,true);
    if ($a_result["errcode"]==0 && $s_result!='')
    {
        $a_data=$a_result['signup_list'][0];
        //将允许信息核验的幼儿信息同步至马连道幼儿信息库
        //1.获取幼儿信息
        $s_url=$o_operate->S_Url.'get_student_info.php';
        $a_stu_data=array(
            'license'=>$o_operate->S_License,
            'studentid'=>$a_data['student_id']
        );
        $s_stu_info_result=$o_base->httpsRequest($s_url,$a_stu_data);
        $a_stu_info_result=json_decode($s_stu_info_result,true);
        if ($a_stu_info_result["errcode"]==0  && $s_stu_info_result!='')
        {
            //成功
            $a_stu=$a_stu_info_result['info'];
            $o_stu_save=new Student_Info($o_stu->getStudentId($i));
            foreach ( $a_stu as $s_key => $s_value ) {
                eval ( '$o_stu_save->set'.$s_key.'($s_value );' );
            }
            $o_stu_save->setId($a_stu['CardId']);
            $o_stu_save->setIdType($a_stu['CardType']);
            $o_stu_save->setState(3);
            $o_stu_save->setClassMode($a_data['grade']);
            $o_stu_save->setCompliance($a_data['number']);
            $o_stu_save->Save();
        }else{
            echo($a_data['student_id'].'Error<br><pre>');
            print_r($a_stu_info_result);
        }
    }else{
        echo('Error<br><pre>');
        print_r($a_result);
    }
}
echo($o_stu->getAllCount());
?>