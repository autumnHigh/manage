<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\aathink\twothink\public/../application/user/view/default/login\index.html";i:1542030211;}*/ ?>



<section>
  <div class="span12">
    <form class="login-form" action="" method="post">
      <div class="control-group">
        <label class="control-label" for="inputEmail">用户名</label>
        <div class="controls">
          <input type="text" id="inputEmail" class="span3" placeholder="请输入用户名"  ajaxurl="/member/checkUserNameUnique.html" errormsg="请填写1-16位用户名" nullmsg="请填写用户名" datatype="*1-16" value="" name="username">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPassword">密码</label>
        <div class="controls">
          <input type="password" id="inputPassword"  class="span3" placeholder="请输入密码"  errormsg="密码为6-20位" nullmsg="请填写密码" datatype="*6-20" name="password">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="inputPassword">验证码</label>
        <div class="controls">
          <input type="text" id="inputPassword" class="span3" placeholder="请输入验证码"  errormsg="请填写5位验证码" nullmsg="请填写验证码" datatype="*5-5" name="verify">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"></label>
        <div class="controls verifyimg">
          <?php echo captcha_img(); ?>
        </div>
        <div class="controls Validform_checktip text-warning"></div>
      </div>
      <div class="control-group">
        <div class="controls">
          <label class="checkbox">
            <input type="checkbox"> 自动登陆
          </label>
          <p><button type="submit" class="btn">登 陆</button></p>
          <span style="margin-left: 200px;"> <a href="<?php echo url('login/register'); ?>">立即注册</a> </span>
           </div>
      </div>
    </form>
  </div>
</section>


 

<script type="text/javascript">

    $(document)
        .ajaxStart(function(){
            $("button:submit").addClass("log-in").attr("disabled", true);
        })
        .ajaxStop(function(){
            $("button:submit").removeClass("log-in").attr("disabled", false);
        });


    $("form").submit(function(){
        var self = $(this);
        $.post(self.attr("action"), self.serialize(), success, "json");
        return false;

        function success(data){
            if(data.code){
                window.location.href = data.url;
            } else {
                self.find(".Validform_checktip").text(data.msg);
                //刷新验证码
                $(".verifyimg img").click();
            }
        }
    });

    $(function(){
        //刷新验证码
        var verifyimg = $(".verifyimg img").attr("src");
        $(".verifyimg img").click(function(){
            if( verifyimg.indexOf('?')>0){
                $(".verifyimg img").attr("src", verifyimg+'&random='+Math.random());
            }else{
                $(".verifyimg img").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
            }
        });
    });
</script>

