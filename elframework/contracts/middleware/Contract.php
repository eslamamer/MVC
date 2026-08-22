<?php
    namespace contracts\middleware;
    interface Contract
    {
        public function handle(string $request, mixed $next,  array $role);
    }