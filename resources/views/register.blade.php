<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
    <title>注册</title>
</head>
<style>
    * {
        border: none;
        margin: 0;
        padding: 0;
        outline: none;
    }

    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        margin: 5.04rem 1.46rem 0 1.46rem;
    }

    /* 提交按钮 */
    .registe_title {
        font-size: 1.47rem;
    }

    .register {
        display: flex;
        flex-direction: column;
        font-size: 0.75rem;
    }

    /* 验证码框 */
    .phone_box {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .phone_box>#getCode {
        color: #F83A51;
        background-color: #fff
    }

    .phone,
    .verify {
        padding: 1.123rem 0;
        border-bottom: 2px solid rgb(222, 222, 222);
    }

    .phone_box,
    .verify_box {
        margin-top: 0.35rem;
    }

    /* 提交按钮 */
    .submit_button {
        position: fixed;
        box-sizing: border-box;
        bottom: 1.68rem;
        left: 1.46rem;
        right: 1.46rem;
        width: calc(100% - 2.92rem);
        height: 2.51rem;
        color: #ffffff;
        font-size: 0.75rem;
        background-color: #f83a51;
    }
</style>

<body>
    <div id="app">
        <div>
            <div class="registe_title">注册</div>
            <div> {{ $user->name }}邀请你注册
            </div>
        </div>
        <div class="register">
            <div class="phone">
                <label for="phone">手机号码</label>
                <div class="phone_box">
                    <input type="text" name="phone" id="phone" v-model="phone" />
                    <button id="getCode">获取验证码</button>
                </div>
            </div>
            <div class="verify">
                <label for="verify">验证码</label>
                <div class="verify_box">
                    <input type="text" name="verify" id="verify" v-model="verify" placeholder="请输入验证码" />
                </div>
            </div>
            <input type="hidden" name="share_id" id="share_id" value="{{ $user->share_id }}">
        </div>
        <button class="submit_button" id="signUp">提交</button>
    </div>

</body>

</html>
<script>
    $(document).ready(function(){
        function getQueryVariable(variable){
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
            return false;
        }
        function getQuery() {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == "share_id") {
                    return pair[1];
                }
            }
        }
        // 获取验证码
        $("#getCode").click(function(){
            var second = 60;
            const t = /^[1]([3-9])[0-9]{9}$/;
            // console.log(this.getQuery())
            let phone=$("#phone").val()
            if (!t.test(phone)) {
                alert("手机号有误，请重填")
            }else{
                $.ajax({
                    type:"POST",
                    url:"/phone_verify",
                    data:{
                        phone:phone
                    },
                    success:function(){
                        var secondInterval = setInterval(function() {
                            if(second <= 0) {
                                $('#getCode').attr("disabled", false);
                                $('#getCode').html("发送验证码");
                                $('#getCode').css("color","#F83A51")
                                second = 60;
			                    clearInterval(secondInterval);
			                    secondInterval = undefined;
                            } else {
                                $('#getCode').attr("disabled", true);
                                $('#getCode').html(second + "秒后重发");
                                $('#getCode').css("color","grey")
                                second--;
                            }
                        }, 1000); 
                    },
                    error:function(e){
                        console.log(e)
                        alert("获取验证码失败")
                    }
                })
            }
        })
        // 提交注册
        $("#signUp").click(function(){
            const t = /^[1]([3-9])[0-9]{9}$/;
            let verify = $("#verify").val()
            let phone = $("#phone").val()
            let share_id = $("#share_id").val()
            if (!t.test(phone)) {
                alert("手机号码有误，请重填");
                return;
            } else if (verify === "") {
                alert("验证码不能为空");
                return;
            }else{
                $.ajax({
                    type:"POST",
                    url:"/user",
                    data:{
                        phone:phone,
                        captcha:verify,
                        share_id:share_id
                    },
                    succes:function(){
                        alert("注册成功")
                    },
                    error:function(e){
                        console.log(e)
                        alert("注册失败")
                    }
                })
            }
        })
    })
</script>