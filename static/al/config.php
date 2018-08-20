<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017102109429314",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAms5DD5QfCRMtH4PNoP70K54meyfyPh5B1VDoSjKFnP9dkULvZw51Hdz2wyyVtpxX1LS90LEM6xBduQPasoWGPhmZdQVi0JfG7Bh5Rq4Xjw6cp6gvxEObWo5Xholf7uz9N5sxEksG31UOWm6erQ84D3vDFUhrL6D3zWftXIo5w/bgRaQrdc+NTf6IaNfYmivGLQ/9hCbSvdMpyvfP8LUoGcm+0sIyx2fRsgtlxMDd/D4TU5ha4ShMJoVNyMvjIttt98DW9d0Y07l4XfKU5C5s/DkB9A9pfFHEoB420bp9e5M2yCSn385MLEdXL3S2owPi717x6v5ZqlS3qAMasYWDwQIDAQABAoIBAGxVYfq59oocQFyomTNMmEUZ9OYEy3KLLBkC+LxL5NM8phcs12qwZGdUpd9qCQ91E8YIAjnUXSz3FA+Q0fBSnuJAefK5pTBCtvOsINrEpDn5yMlPWrYndcWGjVvaMSd786yBT3L0zEdoN5YziZmkZ9/2BUyUlGYNaLz3ONWk6c3nlOHqSLrioWkZIG3Mo/mjX0ed4rRxPbai1x8QVH/kArkhcathgQNKytdbDwcSlIJX2z9Fk6dgQrMnx1qMuUuPuJAmEUBgZelHLNcSVcTQx7Pk3hLOMWk1lQxzmpMvYJ7/SB+DgobuWcWNlfOmaQpDjxbhwvV7T/BTuuj7Uvr0LAECgYEAyLX3D4ugyvUwNBnAfbRodRvKvi5MQK7Lr307KzBu6ArNv1Djc7WUD0NzeeOyglyaYIHbFBqT5tLmRlC183jT3gJK1ZUsaomMJjSAKlMCf1EB9Ej/Wxkchv/JIPbzdHnx5Asp7bE9gKfAbuVk4qMNiS/lj4ErPAu1iWe30OydjaECgYEAxXMXNe5IhfbMCEG7xmnTz7x7PR+FPAbGsj1ldSdKP71VDraVhBfRTYC1Awa66WWvzV8UAe31xUazwHA1ky7BJY75jlVd1s9l+0d3ERyUoqDbiKB49FzciFyD0m1Ygp2o8RXEJ0Pu/u1OrE+kQx6Qb3KbgdIv1VTJe+9sThI7AiECgYB3Gxyo2fgqWMQpNtr2/dc7H6n5n+naPKBc3Jj/MTevdbHRBYRkhu18/U8Klye4mpF2EblbPcZlJORH999xw1MfHQchpet8sXE8vs0L0MTbnsvlFmiKu+Uk66eEa2ffx/nWlRVlm1dfAK1+YZyzrYT70zOMLF/muyAYkTcQwUlh4QKBgQCuarBCL69Yx14MnSRmbO1yQCkNIV7sW4ABy0JobsCj9XfBe4AwI2n8cIl1luhdbDoTzL07xxynm4EFqRlqXo63wsin9rjiHGsVwVdogjq6PiYvVrICClW1DyRTKcxZ9TNbY8LWfKgOAUrR47hSohksmazMzQL8C92/4QtnG6uMgQKBgETTkz881MVKdq/NyNZxUb7EU1ttyKP83yqnKuT+jlW3RjOukIB66aRVbH3tl4E+vvVQdLY6etvJfeVZijP8rd1v0QlGnVQIydFiI4PQMgJYOlmJfeezFArWq7TbNwX0a9Dp/OZkoj+AaeAeqa7MIsQ3G8oPyify7scGVGxBJM/J",
				
		//异步通知地址
		//'notify_url' => "http://工程公网访问地址/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		'notify_url' => "http://game.koko360.com/index/notify/zhifubao",
		
		//同步跳转
		//'return_url' => "http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",
		'return_url' => "http://game.koko360.com/index/recharge/zhifu",
		

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAytTlHgBI/G9ZwOVbgZZt28HZ59LcFMjDH+eDvtkoYHt5Lp+BRt1+Xtx+4fj/9f2OiH79sEkOI3MSjZ3Q6gT3Pk7U1Wn1AnbfKrQE4iMRIZ/IWnyE4kk7tWVfiBsvEzNiwhq7D0jd6FociwFHYQiD/Keo8L5Yngfi4BN5D48igC4j1N896s4Y4s3QONVM9fs3C5nNzXVd4fY3Mkn6DHT2PU7xDeBbWEqCD1FgeTTk/dS3XnGh50q8pBxh4Cpsz0k3/1jT55Dz5xWSuQBYkphvfNAybvqfw1LuxQEQbMK19f0oLGZw8oLSwtzJP/jxntwOHnhbEMcz78yCyjEwl0kpeQIDAQAB",
				
	
);