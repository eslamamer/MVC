<?php
    namespace contracts;
    interface Middleware
    {
        public function handle(string $request, mixed $next);
    }