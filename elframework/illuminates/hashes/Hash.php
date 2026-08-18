<?php
    namespace illuminates\hashes;

    class Hash{

        public static function encript(string $value): string{
            $cipher_mode     = config('session.encryption_mode');
            $cipher_key      = config('session.encryption_key');
            $iv_len          = openssl_cipher_iv_length($cipher_mode);
            $iv              = openssl_random_pseudo_bytes($iv_len);
            $cipher_text_raw = openssl_encrypt($value, $cipher_mode, $cipher_key,OPENSSL_RAW_DATA ,$iv);
            $hmac            = hash_hmac("sha256", $cipher_text_raw,$cipher_key,true);
            $cipher_text     = base64_encode($iv.$hmac.$cipher_text_raw);
            return $cipher_text;
        }
        
        public static function decrypt(string $chipertext): string{
            $cipher = config('session.encryption_mode');
            $key = config('session.encryption_key');
            $convert = base64_decode($chipertext);           // ① يفك base64
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = substr($convert, 0, $ivlen);                // ② يقطع أول 16 بايت = الـ IV
            $hmac = substr($convert, $ivlen, 32);             // ③ يقطع الـ 32 بايت اللي بعدها = HMAC
            $ciphertext_raw = substr($convert, $ivlen + 32);  // ④ الباقي = النص المشفر الفعلي
            $original_text = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);  // ⑤ يعيد حساب البصمة
            if (hash_equals($hmac, $calcmac)) {   // ⑥ يقارن البصمتين
                return $original_text;
            }
            return '';   // ⑦ لو مش متطابقين، البيانات اتلاعب بيها → يرجع فاضي بدل ما يرجع بيانات مشكوك فيها
        }

        public static function make(string $password):string{
            return password_hash($password, config('hash.bcrypt_algo'));
        }

        public static function check(string $password, string $hashed):bool{
            return password_verify($password, $hashed);
        }
    }

    