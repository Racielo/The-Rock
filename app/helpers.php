<?php
function h($value): string { return e($value ?? ''); }
function utf_lower($value): string { return mb_strtolower($value ?? '', 'UTF-8'); }
function user_initial($value): string { return mb_strtoupper(mb_substr($value ?? '', 0, 1)); }
