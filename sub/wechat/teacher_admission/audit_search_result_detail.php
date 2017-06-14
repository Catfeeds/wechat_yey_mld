		<div class="weui-cells__title">基本信息</div>
	    <div class="weui-cells" style="margin-top:0px;">
			<div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">幼儿姓名</label></div>
				<div class="weui-cell__bd">
                    <input class="weui-input" id="Vcl_Name" name="Vcl_Name" placeholder="必填">
                </div>
	        </div>
	        <div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">证件号码</label></div>
				<div class="weui-cell__bd">
                    <input class="weui-input" id="Vcl_ID" name="Vcl_ID" onBlur="check_id()" placeholder="必填">
                </div>
	        </div>
	        	<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label" style="width:150px;">户籍所在社区</label></div>
					<div class="weui-cell__bd">
				        <span style="color:#999999" id="Vcl_Shequ"></span>
				   </div>
			    </div>
				<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label" style="width:150px;">户籍详细地址</label></div>
					<div class="weui-cell__bd">
				        <span style="color:#999999" id="Vcl_HAdd"></span>
				   </div>
			    </div>
			<div class="weui-cell" id="z_address">
				<div class="weui-cell__hd"><label class="weui-label" style="width:150px;">现住址详细地址</label></div>
				<div class="weui-cell__bd">
					<span style="color:#999999" id="Vcl_ZAdd"></span>
			    </div>
		    </div>
		</div>