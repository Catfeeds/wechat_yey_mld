<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate_Admission extends Bn_Basic {
	protected $N_PageSize= 25;
	public $S_Url= '';
	Public $S_License= '';
	public $N_Number=0;
	public function __construct() {
	    $o_system_setup=new Base_Setup(1);
	    $this->S_Url=$o_system_setup->getXchyeySignupUrl();
	    $this->S_License=$o_system_setup->getXchyeySignupLicense();
	}
	public function SignupTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120101 ))return;//如果没有权限，不返回任何值
	    $this->GlobalTable('SignupTable',1,true);
	}
	public function SignupRejectTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120102 ))return;//如果没有权限，不返回任何值
	    $this->GlobalTable('SignupRejectTable',2);
	}
	public function EnrollRejectTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120106 ))return;//如果没有权限，不返回任何值
	    $this->GlobalTable('EnrollRejectTable',6);
	}
	public function AuditRejectTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120104 ))return;//如果没有权限，不返回任何值
	    $this->GlobalTable('AuditRejectTable',4);
	}
	public function WaitingEnrollTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120105 ))return;//如果没有权限，不返回任何值
	    $this->setHealthNumber();
	    $this->GlobalTable('WatiingEnrollTable',5,true);
	}
	public function WaitingAuditTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120103 ))return;//如果没有权限，不返回任何值
	    $this->setHealthNumber();
	    $this->GlobalTable('WatiingAuditTable',3,true,true);
	}
	public function WaitingDispatchTable($n_uid)
	{
	    $this->N_PageSize= 50;
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120109 ))return;//如果没有权限，不返回任何值
	    $this->setHealthNumber();
	    $this->GlobalTable('WatingDispatchTable',7,true);
	}
	public function Output($n_uid)
	{
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    sleep(1);
	    $o_user = new Single_User ( $n_uid );
	    if (!$o_user->ValidModule ( 120100 ))return;//如果没有权限，不返回任何值
	    $s_url=$this->S_Url.'export_signup_info.php';
	    $a_data=array(
	        'license'=>$this->S_License,
	        'state'=>$this->getPost('state') // 1：等待确认信息核验，2：不允许信息核验，3：允许信息核验:4：核验不通过:5：核验通过等待录取:6：补录取:7：已录取等待分班
	    );
	    $s_result=$this->HttpsRequest($s_url,$a_data);
	    $a_result=json_decode($s_result,true);
	    $n_count=0;
	    if ($a_result["errcode"]==0 && $s_result!='')
	    {
	        $a_general = array (
	            'success' => 1,
	            'url' =>$a_result["downloadurl"]
	        );
	        echo (json_encode ( $a_general ));
	    }else{
	        $a_general = array (
	            'success' => 0
	        );
	        echo (json_encode ( $a_general ));
	    }
	}
	public function AllowAudit($n_uid) {
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    sleep(1);
	    $o_user = new Single_User ( $n_uid );
	    if (! $o_user->ValidModule ( 120101 ))return; //如果没有权限，不返回任何值
	    $s_url=$this->S_Url.'set_allow_audit.php';
	    $a_data=array(
	        'license'=>$this->S_License,
	        'signupid'=>$this->getPost('Id')
	    );
	    $s_result=$this->HttpsRequest($s_url,$a_data);
	    $a_result=json_decode($s_result,true);
	    $n_count=0;
	    if ($a_result["errcode"]==0 && $s_result!='')
	    {
	        $o_system_setup=new Base_Setup(1);
	        $this->GlobalAllowAduit($a_result, $o_system_setup);
	        $this->setReturn ( 'parent.form_return("dialog_success(\'操作成功，点击“确定”继续！\',function(){parent.location.reload()})");' );
	    }else{
	        switch ($a_result["errcode"]) {
	            case 40003:
	                $this->setReturn ( 'parent.form_return("dialog_error(\'请在允许信息核验时间段内操作！\')");' );
	               break;
	            case 40004:
	                $this->setReturn ( 'parent.form_return("dialog_error(\'提交数量超过信息核验剩余容纳人数！<br/><br/>请在《西城幼儿报名服务平台》（xchyey.xchjw.cn）中的“招生设置”->“信息核验”模块中增加信息核验容纳人数后，再进行此操作！\')");' );
	                break;
	            default:
	                $this->setReturn ( 'parent.form_return("dialog_error(\'操作失败，请重试，或与管理员联系！\')");' );
	            break;
	        }
	    }
	}
	public function RejectAudit($n_uid) {
	    if (! ($n_uid > 0)) {
	        $this->setReturn('parent.goto_login()');
	    }
	    sleep(1);
	    $o_user = new Single_User ( $n_uid );
	    if (! $o_user->ValidModule ( 120101 ))return; //如果没有权限，不返回任何值
	    $s_url=$this->S_Url.'set_reject_audit.php';
	    $a_data=array(
	        'license'=>$this->S_License,
	        'signupid'=>$this->getPost('Id'),
	        'reason'=>$this->getPost('RejectReason')
	    );
	    $s_result=$this->HttpsRequest($s_url,$a_data);
	    $a_result=json_decode($s_result,true);
	    $n_count=0;
	    if ($a_result["errcode"]==0 && $s_result!='')
	    {
	        $this->setReturn ( 'parent.form_return("dialog_success(\'操作成功，点击“确定”继续！\',function(){parent.location.reload()})");' );
	    }else{
	        switch ($a_result["errcode"]) {
	            case 40003:
	                $this->setReturn ( 'parent.form_return("dialog_error(\'请在允许信息核验时间段内操作！\')");' );
	                break;
	            case 40005:
	                $this->setReturn ( 'parent.form_return("dialog_error(\'[ 原因 ] 不能为空，请重试！\')");' );
	                break;
	            default:
	                $this->setReturn ( 'parent.form_return("dialog_error(\'操作失败，请重试，或与管理员联系！\')");' );
	                break;
	        }
	    }
	}
	protected function GlobalTable($s_table,$n_state,$b_select=false,$b_limit=false)
    {
        $n_page=$this->getPost('page');
        if ($n_page<=0)$n_page=1;
        $s_url=$this->S_Url.'get_signup_info.php';
        $a_data=array(
            'license'=>$this->S_License,
            'state'=>$n_state, // 1：等待确认信息核验，2：不允许信息核验，3：允许信息核验:4：核验不通过:5：核验通过等待录取:6：补录取:7：已录取等待分班
            'pagesize'=>$this->N_PageSize, //每页显示行数，最大50，最小1，默认50
            'page'=>$n_page,//页数，大于等于1，默认1
            'key'=>$this->getPost('key'),
            'item'=>$this->getPost('item'),
            'sort'=>$this->getPost('sort') ,
        );        
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $n_count=count($a_result["signup_list"]);
        }
        $a_row = array ();        
        for($i = 0; $i < $n_count; $i ++) {
            $a_data=$a_result["signup_list"][$i];
            $s_select=($i+1+$this->N_PageSize*($n_page-1));
            $s_flag='<span class="label label-danger">非西城</span>&nbsp;';
            if($a_data['is_xicheng']==1)
            {
                $s_flag='<span class="label label-success">西城区</span>&nbsp;';
            }
            switch ($a_data['scope'])
            {
                case 4:
                    $s_flag='<span class="label label-success">本社区</span>&nbsp;';
                    break;
                case 3:
                    $s_flag='<span class="label label-success">本街道</span>&nbsp;';
                    break;
                case 2:
                    $s_flag='<span class="label label-success">本学区</span>&nbsp;';
                    break;
            }
            if ($a_data['same']==1)
            {
                $s_flag.='<span class="label label-success">一致</span>';
            }else{
                $s_flag.='<span class="label label-danger">不一致</span>';
            }
            //构建监护人
            $s_jh=$a_data['jh1_connection'].' '.$a_data['jh1_name'].' '.$a_data['jh1_phone'];
            if($a_data['jh2_connection']!='')
            {
                $s_jh.='<br/>'.$a_data['jh2_connection'].' '.$a_data['jh2_name'].' '.$a_data['jh2_phone'];
            }
            if ($b_select)
            {
                $s_select='<input style="margin-top:0px;" type="checkbox" value="' . $a_data['id']. '" checked="checked"/>';
                //获取是否可以显示勾选框，根据志愿录取时间
                if ($a_data['number']>$this->N_Number && $b_limit)
                {
                    $s_select='';
                }
            }else{
                $s_reason='<div style="color:#ed6b75;padding-top:5px;">原因：'.$a_data['reason'].'</div>';
            }
            $a_button=array();
            array_push ( $a_button, array ('查看', "location='student_view.php?id=".$a_data['student_id']."'" ) );
            array_push ($a_row, array (
                $s_select,
                $a_data['id'].'<br/><span style="color:#999999">'.date('Y-m-d',strtotime($a_data['signup_date'])).'</span>',
                $a_data['grade'].'<br/><span style="color:#1f78b5">第 '.$a_data['number'].' 志愿</span>',
                $a_data['name'].'<br/><span style="color:#999999">'.$a_data['sex'].'</span>',
                $a_data['birthday'],
                $a_data['card_id'].'<br/><span style="color:#999999">'.$a_data['card_type'].'</span>',
                $s_jh,
                $s_flag.$s_reason,
                $a_button
            ));
        }
        //标题行,列名，排序名称，宽度，最小宽度
        $a_title = array ();
        if ($b_select)
        {
            $a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)" checked="checked"/> 全选', '', 0, 40);
        }else{
            $a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
        }
        $a_title=$this->setTableTitle($a_title,'编号/报名时间', 'Id', 0, 0);
        $a_title=$this->setTableTitle($a_title,'年级/志愿', 'Number', 0, 0);
        $a_title=$this->setTableTitle($a_title,'姓名/性别', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'出生日期', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'证件号码/证件类型', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'第一监护人/电话', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'户籍/住籍是否一致', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 90, 0);
        $this->SendJsonResultForTable($a_result["total"],$s_table, 'yes', $n_page, $a_title, $a_row);
    }
    public function setHealthNumber()
    {
        $s_url=$this->S_Url.'get_signup_setup.php';
        $a_data=array(
            'license'=>$this->S_License,
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            if ($this->GetTimeCut()>strtotime($a_result["admission_1_start_date"]))
            {
                $this->N_Number=1;
            }
            if ($this->GetTimeCut()>strtotime($a_result["admission_2_start_date"]))
            {
                $this->N_Number=2;
            }
            if ($this->GetTimeCut()>strtotime($a_result["admission_3_start_date"]))
            {
                $this->N_Number=3;
            }
            if ($this->GetTimeCut()>strtotime($a_result["admission_4_start_date"]))
            {
                $this->N_Number=4;
            }
            if ($this->GetTimeCut()>strtotime($a_result["admission_5_start_date"]))
            {
                $this->N_Number=5;
            }
            if ($this->GetTimeCut()>strtotime($a_result["admission_stop_date"]))
            {
                $this->N_Number=0;
            }
            //如果在补录时间范围内，可以录取所有志愿
            if ($this->GetTimeCut()>strtotime($a_result["supplement_start_date"]) && $this->GetTimeCut()<strtotime($a_result["supplement_stop_date"]) )
            {
                $this->N_Number=5;
            }
        }     
    }
    public function RejectHealth($n_uid) {
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        sleep(1);
        $o_user = new Single_User ( $n_uid );
        if (! $o_user->ValidModule ( 120103 ))return; //如果没有权限，不返回任何值
        $s_url=$this->S_Url.'set_reject_health.php';
        $a_data=array(
            'license'=>$this->S_License,
            'signupid'=>$this->getPost('Id'),
            'reason'=>$this->getPost('RejectReason')
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            for($i=0;$i<count($a_result['success_id']);$i++)
            {
                //设置本地数据状态为0
                $o_temp=new Student_Info($a_result['success_id'][$i]);
                $o_temp->setState(4);
                $o_temp->Save();
            }
            $this->setReturn ( 'parent.form_return("dialog_success(\'操作成功，点击“确定”继续！\',function(){parent.location.reload()})");' );
        }else{
            switch ($a_result["errcode"]) {
                case 40005:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'[ 原因 ] 不能为空，请重试！\')");' );
                    break;
                default:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'操作失败，请重试，或与管理员联系！\')");' );
                    break;
            }
        }
    }
    public function AllowHealth($n_uid) {
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        sleep(1);
        $o_user = new Single_User ( $n_uid );
        if (! $o_user->ValidModule ( 120103 ))return; //如果没有权限，不返回任何值
        $s_url=$this->S_Url.'set_allow_health.php';
        $a_data=array(
            'license'=>$this->S_License,
            'signupid'=>$this->getPost('Id')
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $o_system_setup=new Base_Setup(1);
            $this->GlobalAllowHealth($a_result, $o_system_setup);
            $this->setReturn ( 'parent.form_return("dialog_success(\'操作成功，点击“确定”继续！\',function(){parent.location.reload()})");' );
        }else{
            switch ($a_result["errcode"]) {
                case 40005:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'[ 原因 ] 不能为空，请重试！\')");' );
                    break;
                case 40006:
                    $s_temp='';
                    for($i=0;$i<count($a_result['err_id']);$i++)
                    {
                        if($i==0)
                        {
                            $s_temp.=$a_result['err_id'][$i];
                        }else{
                            $s_temp.='，'.$a_result['err_id'][$i];
                        }
                    }
                    $this->setReturn ( 'parent.form_return("dialog_error(\'[ <b>'.$s_temp.'</b> ]<br/><br/>以上编号的报名记录，已被其他幼儿园发送体检通知，请取消勾选后重试！\')");' );
                    break;
                default:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'操作失败，请重试，或与管理员联系！\')");' );
                    break;
            }
        }
    }
    public function RejectEnroll($n_uid) {
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        sleep(1);
        $o_user = new Single_User ( $n_uid );
        if (! $o_user->ValidModule ( 120105 ))return; //如果没有权限，不返回任何值
        $s_url=$this->S_Url.'set_reject_enroll.php';
        $a_data=array(
            'license'=>$this->S_License,
            'signupid'=>$this->getPost('Id'),
            'reason'=>$this->getPost('RejectReason')
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            for($i=0;$i<count($a_result['success_id']);$i++)
            {
                //设置本地数据状态为0
                $o_temp=new Student_Info($a_result['success_id'][$i]);
                $o_temp->setState(6);
                $o_temp->Save();
            }
            $this->setReturn ( 'parent.form_return("dialog_success(\'操作成功，点击“确定”继续！\',function(){parent.location.reload()})");' );
        }else{
            switch ($a_result["errcode"]) {
                case 40005:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'[ 原因 ] 不能为空，请重试！\')");' );
                    break;
                default:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'操作失败，请重试，或与管理员联系！\')");' );
                    break;
            }
        }
    }
    public function AllowEnroll($n_uid) {
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        sleep(1);
        $o_user = new Single_User ( $n_uid );
        if (! $o_user->ValidModule ( 120105 ))return; //如果没有权限，不返回任何值
        $s_url=$this->S_Url.'set_allow_enroll.php';
        $a_data=array(
            'license'=>$this->S_License,
            'signupid'=>$this->getPost('Id')
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $o_system_setup=new Base_Setup(1);
            $this->GlobalAllowEnroll($a_result, $o_system_setup);
            $this->setReturn ( 'parent.form_return("dialog_success(\'操作成功，点击“确定”继续！\',function(){parent.location.reload()})");' );
        }else{
            switch ($a_result["errcode"]) {
                default:
                    $this->setReturn ( 'parent.form_return("dialog_error(\'操作失败，请重试，或与管理员联系！\')");' );
                    break;
            }
        }
    }
    public function getWaitRead($n_uid)
    {
        //因为这个模块带提醒数字图标，所以必须有此方法
        if (! ($n_uid > 0)) {
            //直接退出系统
            return 0;
        }
        $o_user = new Single_User ( $n_uid );
        $n_count=0;
        if ($o_user->ValidModule ( 120101 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>1, 
                'pagesize'=>1, 
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$n_count+$a_result["total"];
            }
        }
        if ($o_user->ValidModule ( 120103 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>3,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$n_count+$a_result["total"];
            }
        }
        if ($o_user->ValidModule ( 120105 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>5,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$n_count+$a_result["total"];
            }
        }
        if ($o_user->ValidModule ( 120109 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>7,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$n_count+$a_result["total"];
            }
        }
        return $n_count;
    }
    public function getWaitRead120101($n_uid)
    {
        //因为这个模块带提醒数字图标，所以必须有此方法
        if (! ($n_uid > 0)) {
            //直接退出系统
            return 0;
        }
        $n_count=0;
        $o_user = new Single_User ( $n_uid );
        if ($o_user->ValidModule ( 120101 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>1,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$a_result["total"];
            }
        }
        $a_result=array(
            'number'=>$n_count
        );
        echo(json_encode ($a_result));
    }
    public function getWaitRead120103($n_uid)
    {
        //因为这个模块带提醒数字图标，所以必须有此方法
        if (! ($n_uid > 0)) {
            //直接退出系统
            return 0;
        }
        $n_count=0;
        $o_user = new Single_User ( $n_uid );
        if ($o_user->ValidModule ( 120103 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>3,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$a_result["total"];
            }
        }
        $a_result=array(
            'number'=>$n_count
        );
        echo(json_encode ($a_result));
    }
    public function getWaitRead120105($n_uid)
    {
        //因为这个模块带提醒数字图标，所以必须有此方法
        if (! ($n_uid > 0)) {
            //直接退出系统
            return 0;
        }
        $n_count=0;
        $o_user = new Single_User ( $n_uid );
        if ($o_user->ValidModule ( 120105 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>5,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$a_result["total"];
            }
        }
        $a_result=array(
            'number'=>$n_count
        );
        echo(json_encode ($a_result));
    }
    public function getWaitRead120109($n_uid)
    {
        //因为这个模块带提醒数字图标，所以必须有此方法
        if (! ($n_uid > 0)) {
            //直接退出系统
            return 0;
        }
        $n_count=0;
        $o_user = new Single_User ( $n_uid );
        if ($o_user->ValidModule ( 120109 )) {
            $s_url=$this->S_Url.'get_signup_info.php';
            $a_data=array(
                'license'=>$this->S_License,
                'state'=>7,
                'pagesize'=>1,
                'page'=>1
            );
            $s_result=$this->HttpsRequest($s_url,$a_data);
            $a_result=json_decode($s_result,true);
            if ($a_result["errcode"]==0 && $s_result!='')
            {
                $n_count=$a_result["total"];
            }
        }
        $a_result=array(
            'number'=>$n_count
        );
        echo(json_encode ($a_result));
    }
    public function WaitingSupplementTable($n_uid)
    {
        $this->N_PageSize= 50;
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        $o_user = new Single_User ( $n_uid );
        if (!$o_user->ValidModule ( 120107 ))return;//如果没有权限，不返回任何值
        $n_page=$this->getPost('page');
        if ($n_page<=0)$n_page=1;
        $s_url=$this->S_Url.'get_supplement.php';
        $a_data=array(
            'license'=>$this->S_License,
            'pagesize'=>$this->N_PageSize, //每页显示行数，最大50，最小1，默认50
            'page'=>$n_page,//页数，大于等于1，默认1
            'key'=>$this->getPost('key'),
            'item'=>$this->getPost('item'),
            'sort'=>$this->getPost('sort') ,
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $n_count=count($a_result["signup_list"]);
        }
        $a_row = array ();
        for($i = 0; $i < $n_count; $i ++) {
            $a_data=$a_result["signup_list"][$i];
            $s_select=($i+1+$this->N_PageSize*($n_page-1));
            $s_flag='<span class="label label-danger">非西城</span>&nbsp;';
            if($a_data['is_xicheng']==1)
            {
                $s_flag='<span class="label label-success">西城区</span>&nbsp;';
            }
            switch ($a_data['scope'])
            {
                case 4:
                    $s_flag='<span class="label label-success">本社区</span>&nbsp;';
                    break;
                case 3:
                    $s_flag='<span class="label label-success">本街道</span>&nbsp;';
                    break;
                case 2:
                    $s_flag='<span class="label label-success">本学区</span>&nbsp;';
                    break;
            }
            if ($a_data['same']==1)
            {
                $s_flag.='<span class="label label-success">一致</span>';
            }else{
                $s_flag.='<span class="label label-danger">不一致</span>';
            }
            $a_button=array();
            array_push ( $a_button, array ('查看', "location='student_view.php?id=".$a_data['student_id']."'" ) );
            //获取当前状态
            $s_state='';
            switch ($a_data['state'])
            {
                case 2:
                    $s_state='未允许信息核验<br/><span style="color:#ed6b75;">原因：'.$a_data['reason'].'</span>';
                    array_push ( $a_button, array ('允许核验', "allow('".$a_data['id']."','".$a_data['name']."',2)" ) );//查看
                    break;
                case 4:
                    $s_state='信息核验不通过<br/><span style="color:#ed6b75;">原因：'.$a_data['reason'].'</span>';
                    array_push ( $a_button, array ('允许体检', "allow('".$a_data['id']."','".$a_data['name']."',4)" ) );//查看
                    break;
                case 6:
                    $s_state='未录取<br/><span style="color:#ed6b75;">原因：'.$a_data['reason'].'</span>';
                    array_push ( $a_button, array ('录取', "allow('".$a_data['id']."','".$a_data['name']."',6)" ) );//查看
                    break;
            }
            //构建监护人
            $s_jh=$a_data['jh1_connection'].' '.$a_data['jh1_name'].' '.$a_data['jh1_phone'];
            if($a_data['jh2_connection']!='')
            {
                $s_jh.='<br/>'.$a_data['jh2_connection'].' '.$a_data['jh2_name'].' '.$a_data['jh2_phone'];
            }
            $s_reason='<div style="color:#ed6b75;padding-top:5px;">原因：'.$a_data['reason'].'</div>';      
            array_push ($a_row, array (
                $s_select,
                $a_data['id'].'<br/><span style="color:#999999">'.date('Y-m-d',strtotime($a_data['signup_date'])).'</span>',
                $a_data['grade'].'<br/><span style="color:#1f78b5">第 '.$a_data['number'].' 志愿</span>',
                $a_data['name'].'<br/><span style="color:#999999">'.$a_data['sex'].'</span>',
                $a_data['birthday'],
                $a_data['card_id'].'<br/><span style="color:#999999">'.$a_data['card_type'].'</span>',
                $s_jh,
                $s_state,
                $s_flag,
                $a_button
            ));
        }
        //标题行,列名，排序名称，宽度，最小宽度
        $a_title = array ();
        $a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 40, 0);
        $a_title=$this->setTableTitle($a_title,'编号/报名时间', 'Id', 0, 0);
        $a_title=$this->setTableTitle($a_title,'年级/志愿', 'Number', 0, 0);
        $a_title=$this->setTableTitle($a_title,'姓名/性别', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'出生日期', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'证件号码/证件类型', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'第一监护人/电话', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'当前状态', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'户籍/住籍是否一致', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 100, 0);
        $this->SendJsonResultForTable($a_result["total"],'', 'yes', $n_page, $a_title, $a_row);
    }
    public function AllowSupplement($n_uid) {
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        sleep(1);
        $o_user = new Single_User ( $n_uid );
        if (! $o_user->ValidModule ( 120107 ))return; //如果没有权限，不返回任何值
        $s_url=$this->S_Url.'set_allow_supplement.php';
        $a_data=array(
            'license'=>$this->S_License,
            'signupid'=>$this->getPost('Id')
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $o_system_setup=new Base_Setup(1);
            //获取成功数据后，发送通知
            $a_data=$a_result['success_id'][0];
            if ($a_data['state']==3)
            {
                //调用允许信息核验事件
                $this->GlobalAllowAduit($a_result, $o_system_setup);
            }
            if ($a_data['state']==5)
            {
                //调用允许信息核验事件
                $this->GlobalAllowHealth($a_result, $o_system_setup);
            }
            if ($a_data['state']==7)
            {
                //调用允许信息核验事件
                $this->GlobalAllowEnroll($a_result, $o_system_setup);
            }
            $a_general = array (
                'success' => 1
            );
        }else{
            $s_msg='';
            switch ($a_result["errcode"]) {
                case 40003:
                    $s_msg='请在允许补录时间段内操作！';
                    break;
                case 40006:
                    $s_msg='该报名记录，已被其他幼儿园补录，请更换！';
                    break;
                case 40007:
                    $s_msg='提交数据出现错误，请重试，或与管理员联系！错误代码 [1001]';
                    break;
                case 40008:
                    $s_msg='提交数据出现错误，请重试，或与管理员联系！错误代码 [1002]';
                    break;
                case 40004:
                    $s_msg='信息核验时间段剩余容纳人数不足！<br/><br/>请在《西城幼儿报名服务平台》（xchyey.xchjw.cn）中的“招生设置”->“信息核验”模块中增加信息核验容纳人数后，再进行此操作！';
                    break;
                default:
                    $s_msg='操作失败，请重试，或与管理员联系！';
                    break;
            }
            $a_general = array (
                'success' => 0,
                'text' => $s_msg
            );
        }
        echo (json_encode ( $a_general ));
        return;
    }
    protected function GlobalAllowAduit($a_result,$o_system_setup)
    {
        //获取成功数据后，发送通知
        for($i=0;$i<count($a_result['success_id']);$i++)
        {
            $a_data=$a_result['success_id'][$i];
            //将允许信息核验的幼儿信息同步至马连道幼儿信息库
            //1.获取幼儿信息
            $s_url=$this->S_Url.'get_student_info.php';
            $a_stu_data=array(
                'license'=>$this->S_License,
                'studentid'=>$a_data['student_id']
            );
            $s_stu_info_result=$this->httpsRequest($s_url,$a_stu_data);
            $a_stu_info_result=json_decode($s_stu_info_result,true);
            if ($a_stu_info_result["errcode"]==0  && $s_stu_info_result!='')
            {
                //成功
                $a_stu=$a_stu_info_result['info'];
                $o_stu=new Student_Info();
                foreach ( $a_stu as $s_key => $s_value ) {
                    eval ( '$o_stu->set'.$s_key.'($s_value );' );
                }
                $o_stu->setStudentId($a_data['signupid']);
                $o_stu->setId($a_stu['CardId']);
                $o_stu->setIdType($a_stu['CardType']);
                $o_stu->setState(3);
                $o_stu->setClassMode($a_data['grade']);
                $o_stu->setCompliance($a_data['number']);
                $o_stu->Save();
            }else{
                $o_stu=new Student_Info();
                $o_stu->setStudentId($a_data['signupid']);
                $o_stu->Save();
            }
            //绑定微信用户
            $o_wechat_parent=new WX_User_Info();
            $o_wechat_parent->PushWhere ( array ('&&', 'OpenId', '=', $a_data['openid'] ) );
            $o_wechat_parent->PushWhere ( array ('&&', 'OpenId', '<>', '' ) );
            if ($o_wechat_parent->getAllCount()>0)
            {
                $o_stu_wechat=new Student_Info_Wechat();
                $o_stu_wechat->setUserId($o_wechat_parent->getId(0));
                $o_stu_wechat->setStudentId($a_data['signupid']);
                $o_stu_wechat->Save();
                //发送微信信息
                $o_msg=new Wechat_Wx_User_Reminder();
                $o_msg->setUserId($o_wechat_parent->getId(0));
                $o_msg->setCreateDate($this->GetDateNow());
                $o_msg->setSendDate('0000-00-00');
                $o_msg->setMsgId($this->getWechatSetup('MSGTMP_02'));
                $o_msg->setOpenId($o_wechat_parent->getOpenId(0));
                $o_msg->setActivityId(0);
                $o_msg->setSend(0);
                $o_msg->setFirst('如下幼儿初步审核已经通过，请您按时间地点携带核验资料原件、复印件以及“报名登记表”进行信息核验，如错过信息核验视为自行放弃入园资格：');
                $o_msg->setKeyword1($a_data['signupid']);
                $o_msg->setKeyword2($a_data['name']);
                $o_msg->setKeyword3($a_data['date']);
                $o_msg->setKeyword4($a_data['time']);
                $o_msg->setKeyword5($a_data['address']);
                $o_msg->setRemark('请用电脑访问：
http://wx.mldyey.com/signup/
并扫码二维码进行登录，即可打印“报名信息登记表”...');
                $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$a_data['signupid'].'');
                $o_msg->setKeywordSum(5);
                $o_msg->Save();
            }
        }
    }
    protected function GlobalAllowHealth($a_result,$o_system_setup)
    {
        for($i=0;$i<count($a_result['success_id']);$i++)
        {
            //设置本地数据状态为0
            $a_data=$a_result['success_id'][$i];
            $o_temp=new Student_Info($a_data['signupid']);
            $o_temp->setState(5);
            $o_temp->Save();
            //给家长发送体检须知
            $o_wechat_parent=new WX_User_Info();
            $o_wechat_parent->PushWhere ( array ('&&', 'OpenId', '=', $a_data['openid'] ) );
            $o_wechat_parent->PushWhere ( array ('&&', 'OpenId', '<>', '' ) );
            if ($o_wechat_parent->getAllCount()>0)
            {
                $o_msg=new Wechat_Wx_User_Reminder();
                $o_msg->setUserId($o_wechat_parent->getId(0));
                $o_msg->setCreateDate($this->GetDateNow());
                $o_msg->setSendDate('0000-00-00');
                $o_msg->setMsgId($this->getWechatSetup('MSGTMP_04'));
                $o_msg->setOpenId($o_wechat_parent->getOpenId(0));
                $o_msg->setActivityId(0);
                $o_msg->setSend(0);
                $o_msg->setFirst('如下幼儿已经通过信息核验，请您按时间地点携带幼儿进行体检，如错过体检视为自行放弃入园资格：');
                $o_msg->setKeyword1($a_data['signupid']);//幼儿编号
                $o_msg->setKeyword2($a_data['name']);//幼儿姓名
                $o_msg->setKeyword3($a_data['date']);//体检时间
                $o_msg->setKeyword4($a_data['address']);//体检地点
                $o_msg->setKeyword5('');//为空
                $o_msg->setRemark('幼儿体检注意事项请点击详情查看。');
                $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$a_data['signupid'].'');
                $o_msg->setKeywordSum(4);
                $o_msg->Save();
            }
        }
    }
    protected function GlobalAllowEnroll($a_result,$o_system_setup)
    {
        for($i=0;$i<count($a_result['success_id']);$i++)
        {
            //设置本地数据状态为0
            $a_data=$a_result['success_id'][$i];
            $o_temp=new Student_Info($a_data['signupid']);
            $o_temp->setState(7);
            $o_temp->Save();
            //给家长发送体检须知
            $o_wechat_parent=new WX_User_Info();
            $o_wechat_parent->PushWhere ( array ('&&', 'OpenId', '=', $a_data['openid'] ) );
            $o_wechat_parent->PushWhere ( array ('&&', 'OpenId', '<>', '' ) );
            if ($o_wechat_parent->getAllCount()>0)
            {
                $o_msg=new Wechat_Wx_User_Reminder();
                $o_msg->setUserId($o_wechat_parent->getId(0));
                $o_msg->setCreateDate($this->GetDateNow());
                $o_msg->setSendDate('0000-00-00');
                $o_msg->setMsgId($this->getWechatSetup('MSGTMP_06'));
                $o_msg->setOpenId($o_wechat_parent->getOpenId(0));
                $o_msg->setActivityId(0);
                $o_msg->setSend(0);
                $o_msg->setFirst('您所报名的如下幼儿已经被我园录取，请家长按时参加幼儿园家长学校培训，未能按时参加培训视为自动放弃入园资格。');
                $o_msg->setKeyword1($a_data['signupid']);//幼儿编号
                $o_msg->setKeyword2($a_data['name']);//幼儿姓名
                $o_msg->setKeyword3($o_temp->getIdType());//证件类型
                $o_msg->setKeyword4($o_temp->getId());//证件编号
                $o_msg->setKeyword5($a_data['grade']);//为空
                $o_msg->setRemark('具体内容请点击详情查看。');
                $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$a_data['signupid'].'');
                $o_msg->setKeywordSum(5);
                $o_msg->Save();
            }
        }
    }
    public function AreaSupplementTable($n_uid)
    {
        sleep(1);
        $this->N_PageSize= 50;
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        $o_user = new Single_User ( $n_uid );
        if (!$o_user->ValidModule ( 120108 ))return;//如果没有权限，不返回任何值
        $n_page=$this->getPost('page');
        if ($n_page<=0)$n_page=1;
        $s_url=$this->S_Url.'get_area_supplement.php';
        $a_key=explode(' ', $this->getPost('key'));
        $a_data=array(
            'license'=>$this->S_License,
            'name'=>$a_key[0], 
            'cardid'=>$a_key[1]
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $n_count=count($a_result["signup_list"]);
        }
        $a_row = array ();
        for($i = 0; $i < $n_count; $i ++) {
            $a_data=$a_result["signup_list"][$i];
            $s_select=($i+1+$this->N_PageSize*($n_page-1));
            $a_button=array();
            array_push ( $a_button, array ('查看', "location='student_view.php?id=".$a_data['student_id']."'" ) );
            //构建监护人
            $s_jh=$a_data['jh1_connection'].' '.$a_data['jh1_name'].' '.$a_data['jh1_phone'];
            if($a_data['jh2_connection']!='')
            {
                $s_jh.='<br/>'.$a_data['jh2_connection'].' '.$a_data['jh2_name'].' '.$a_data['jh2_phone'];
            }
            //构建状态
            $s_state='已被录取，不能补录';
            if($a_data['is_reject']==0 && $a_data['state']<>5 && $a_data['state']<>7)
            {
                array_push ( $a_button, array ('允许核验', "allow('".$a_data['student_id']."','".$a_data['name']."');" ) );
                $s_state='<span class="label label-success">可补录</span>';
            }	 
            array_push ($a_row, array (
                1,
                $a_data['id'].'<br/><span style="color:#999999">'.date('Y-m-d',strtotime($a_data['signup_date'])).'</span>',
                $a_data['name'].'<br/><span style="color:#999999">'.$a_data['sex'].'</span>',
                $a_data['birthday'],
                $a_data['card_id'].'<br/><span style="color:#999999">'.$a_data['card_type'].'</span>',
                $s_jh,
                $s_state,
                $a_button
            ));
        }
        //标题行,列名，排序名称，宽度，最小宽度
        $a_title = array ();
        $a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 40, 0);
        $a_title=$this->setTableTitle($a_title,'编号/报名时间', 'Id', 0, 0);
        $a_title=$this->setTableTitle($a_title,'姓名/性别', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'出生日期', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'证件号码/证件类型', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'第一监护人/电话', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,'状态', '', 0, 0);
        $a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '',90, 0);
        $this->SendJsonResultForTable($a_result["total"],'', 'yes', $n_page, $a_title, $a_row);
    }
    public function AllowAreaSupplement($s_id,$s_grade,$s_openid) {
        
        $s_url=$this->S_Url.'set_allow_area_supplement.php';
        $a_data=array(
            'license'=>$this->S_License,
            'studentid'=>$s_id,
            'gradeid'=>$s_grade,
            'openid'=>$s_openid
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            $o_system_setup=new Base_Setup(1);
            //调用允许信息核验事件
            $this->GlobalAllowAduit($a_result, $o_system_setup);
            return 1;
        }else{
            $s_msg='';
            switch ($a_result["errcode"]) {
                case 40003:
                    $s_msg='操作失败，幼儿园未在允许补录时间段内操作，请与幼儿园！';
                    break;
                case 40006:
                    $s_msg='操作失败，您的已被其他幼儿园补录，不能进行补录！';
                    break;
                case 40007:
                    $s_msg='操作失败，请重试，或与幼儿园联系！错误代码 [1001]';
                    break;
                case 40009:
                    $s_msg='操作失败，请重试，或与幼儿园联系！错误代码 [1005]';
                    break;
                case 40010:
                    $s_msg='操作失败，请重试，或与幼儿园联系！错误代码  [1003]';
                    break;
                case 40011:
                    $s_msg='操作失败，请重试，或与幼儿园联系！错误代码  [1004]';
                    break;
                case 40008:
                    $s_msg='操作失败，请重试，或与幼儿园联系！错误代码  [1002]';
                    break;
                case 40004:
                    $s_msg='操作失败，信息核验时间段剩余容纳人数不足！请与幼儿园！';
                    break;
                default:
                    $s_msg='操作失败，请重试，或与幼儿园联系！';
                    break;
            }
            return $s_msg;
        }
    }
    public function AllowAreaSupplementVerifyAuditTime($n_uid) {
        if (! ($n_uid > 0)) {
            $this->setReturn('parent.goto_login()');
        }
        $o_user = new Single_User ( $n_uid );
        if (!$o_user->ValidModule ( 120108 ))return;//如果没有权限，不返回任何值
        sleep(1);
        //验证是否在补录时间段内
        $s_url=$this->S_Url.'get_signup_setup.php';
        $a_data=array(
            'license'=>$this->S_License,
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            if ($this->GetTimeCut()<strtotime($a_result["supplement_start_date"]) || $this->GetTimeCut()>strtotime($a_result["supplement_stop_date"]))
            {
                $a_general = array (
                    'success' => 0,
                    'text' => '请在允许补录时间段内操作！'
                );
                echo (json_encode ( $a_general ));
                return;
            }
        }
        //验证时段
        $s_url=$this->S_Url.'get_audit_time.php';
        $a_data=array(
            'license'=>$this->S_License,
        );
        $s_result=$this->HttpsRequest($s_url,$a_data);
        $a_result=json_decode($s_result,true);
        $n_count=0;
        if ($a_result["errcode"]==0 && $s_result!='')
        {
            for($i=0;$i<count($a_result["list"]);$i++)
            {
                $a_data=$a_result["list"][$i];
                if ((int)$a_data['sum']>(int)$a_data['used_sum'])
                {
                    $a_general = array (
                        'success' => 1
                    );
                    echo (json_encode ( $a_general ));
                    return;
                }
            }
            $a_general = array (
                'success' => 0,
                'text' => '信息核验时间段剩余容纳人数不足！<br/><br/>请在《西城幼儿报名服务平台》（xchyey.xchjw.cn）中的“招生设置”->“信息核验”模块中增加信息核验容纳人数后，再进行此操作！'
            );
        }else{
            $a_general = array (
                'success' => 0,
                'text' => '操作失败，请重试，或与管理员联系！'
            );
        }
        echo (json_encode ( $a_general ));
        return;
    }
}

?>