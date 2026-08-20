<?php
    namespace illuminates\hashes;

    class Hash{

        public static function encript(string $value): string{
            $cipher_mode     = config('session.encryption_mode');  
        // جيب نوع التشفير (cipher)بيقرا نوع التشفير من config/session.php
        // — قيمته 'AES-128-CBC'. ده الخوارزمية (algorithm) اللي openssl هتستخدمها.
            $cipher_key      = config('session.encryption_key');
        //  جيب مفتاح التشفير (key)بيقرا المفتاح السري من نفس الملف — قيمته 
        //'any' في المرجع (وده المشكلة الأمنية اللي نبّهنا عليها قبل كده).
        // بدون المفتاح ده محدش يقدر يفك أي بيانات مشفرة.
            $iv_len          = openssl_cipher_iv_length($cipher_mode);
        //  جيب طول الـ IV المطلوبكل خوارزمية تشفير محتاجة IV (Initialization Vector)
        // بطول محدد. الدالة دي بتسأل openssl طول الـ IV اللازم لـ AES-128-CBC بالضبط (16 بايت).
            $iv              = openssl_random_pseudo_bytes($iv_len);
       // ولّد IV عشوائيبيولّد IV عشوائي جديد في كل مرة
       // تتنادى الدالة دي. مهم جدًا: لو الـ IV ثابت، نفس القيمة هتدي نفس الناتج المشفر دائمًا
       //، وده ثغرة أمنية.
            $cipher_text_raw = openssl_encrypt($value, $cipher_mode, $cipher_key,OPENSSL_RAW_DATA ,$iv);
       //  التشفير الفعلي (openssl_encrypt)ده قلب العملية الفعلية — بيشفّر
       //  $value بالمفتاح والـ IV، ويرجّع بيانات ثنائية خام (raw) مش base64 لسة.
            $hmac            = hash_hmac("sha256", $cipher_text_raw,$cipher_key,true);
       //  حساب HMAC (للتحقق من التلاعب)بيحسب 'بصمة' (signature) للنص المشفر، عشان لو حد عدّل فيه حرف واحد بعد 
       //    ما اتشفر، الـ decrypt يقدر يكتشف التلاعب (integrity check). ده حماية إضافية غير موجودة مع التشفير العادي لوحده.
            $cipher_text     = base64_encode($iv.$hmac.$cipher_text_raw);
       //  تجميع الكل في نص واحدبيلزق التلات أجزاء في نص واحد 
       //    (IV + HMAC + النص المشفر)، ويعمل base64_encode عشان يبقى نص قابل للتخزين في متغير 
       // أو داتابيز.
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

    