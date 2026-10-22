<?php
declare(strict_types=1);
require __DIR__.'/main.php';
function check(bool $ok): void { if (!$ok) { throw new RuntimeException('Check failed'); } }
function invalid(callable $f): void { try { $f(); } catch (InvalidArgumentException $e) { return; } throw new RuntimeException('Expected rejection'); }
check(outstanding(100,[['ref'=>'DN1','quantity'=>35]])['remaining']===65); invalid(fn()=>outstanding(100,[['ref'=>'DN1','quantity'=>1],['ref'=>'DN1','quantity'=>1]]));
echo "Tests passed\n";
