<?php
// ripemd160算法-40位
echo 'ripemd160：'.hash('ripemd160', 'The quick brown fox jumped over the lazy dog.'),'<br/>';
// crc32算法-8位
echo 'crc32：'.hash('crc32', 'The quick brown fox jumped over the lazy dog.'),'<br/>';
// md2算法-32位
echo 'md2：'.hash('md2', 'The quick brown fox jumped over the lazy dog.'),'<br/>';
// md5算法-32位
echo 'md5：'.hash('md5', 'The quick brown fox jumped over the lazy dog.'),'<br/>';
// gost算法-64位
echo 'gost：'.hash('gost', 'The quick brown fox jumped over the lazy dog.'),'<br/>';
// sha1算法-40位
echo 'sha1：'.hash('sha1', 'The quick brown fox jumped over the lazy dog.'),'<br/>';

echo password_hash("aaaaaaaaa", PASSWORD_DEFAULT)."\n",'<br/>';

//查看哈希值的相关信息
//array password_get_info (string $hash)

//创建hash密码
//string password_hash(string $password , integer $algo [, array $options ])

//判断hash密码是否特定选项、算法所创建
//boolean password_needs_rehash (string $hash , integer $algo [, array $options ] 

//boolean password_verify (string $password , string $hash)
//验证密码
$passwords = 'password1234567';
$password = 'password123456';//原始密码
$hash_password = password_hash($password, PASSWORD_BCRYPT);//使用BCRYPT算法加密密码
if (password_verify($passwords , $hash_password)){
   echo "密码匹配";
}else{  
   echo "密码错误";
}


?>