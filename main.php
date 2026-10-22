<?php
declare(strict_types=1);
// Reconcile delivery notes with deduplicated source references.
function outstanding(int $ordered,array $receipts): array {
    if ($ordered<0) { throw new InvalidArgumentException('Negative order'); }
    $seen=[]; $total=0;
    foreach ($receipts as $row) {
        if (!is_string($row['ref']) || trim($row['ref'])==='' || isset($seen[$row['ref']]) || !is_int($row['quantity']) || $row['quantity']<=0) {
            throw new InvalidArgumentException('Invalid or duplicated receipt');
        }
        $seen[$row['ref']]=true; $total+=$row['quantity'];
    }
    return ['received'=>$total,'remaining'=>max(0,$ordered-$total),'over_delivery'=>max(0,$total-$ordered)];
}
if (realpath($_SERVER['SCRIPT_FILENAME']??'')===__FILE__) {
    echo json_encode(outstanding(100,[['ref'=>'DN-01','quantity'=>35],['ref'=>'DN-02','quantity'=>40]])).PHP_EOL;
}
