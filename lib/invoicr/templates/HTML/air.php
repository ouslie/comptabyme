<?php
/*
 * BLUEBERRY HTML INVOICE THEME
 * Visit https://code-boxx.com/invoicr-php-invoice-generator for more
 */
// HTML HEADER & STYLES
$this->data = "<!DOCTYPE html><html><head><style>".
"html,body{font-family:sans-serif}#invoice{max-width:800px;margin:0 auto}#company,#billship{margin-bottom:30px}#billship,#company,#items{width:100%;border-collapse:collapse}#company td,#billship td,#items td,#items th{padding:10px}#company td{vertical-align:top}#bigi{margin-bottom:20px;font-size:28px;font-weight:700;color:#258ec7}#co-addr{font-size:.95em;color:#888}#co-right img{max-width:180px;height:auto}#billship td{width:33%}#items th{text-align:left;background:#98c5dc;padding:20px 10px}#items td{background:#e4eff5;border-bottom:1px solid #c8d2d7}.idesc{color:#6099b6}#items tr.ttl td{background:#98c5dc;border-bottom:none;font-weight:700}.right{text-align:right}#notes{background:#e4eff5;padding:10px;margin-top:30px}".
"</style></head><body><div id='invoice'>";

// INVOICE INFO
$this->data .= "</td><td>";
foreach ($this->invoice as $i) {
	$this->data .= "<strong>$i[0]:</strong> $i[1]<br>";
}
$this->data .= "</td></tr></table>";
// ITEMS
$this->data .= "<table id='items'><tr><th>ITEM</th><th>AMOUNT</th></tr>";
foreach ($this->items as $i) {
	$this->data .= "<tr><td><div>".$i['name']."</div><td>".$i['total']."</td></tr>";
}
// TOTALS
if (count($this->totals)>0) { foreach ($this->totals as $t) {
	$this->data .= "<tr class='ttl'><td class='right' colspan='3'>$t[0]</td><td>$t[1]</td></tr>";
}}
$this->data .= "</table>";
// NOTES
if (count($this->notes)>0) {
	$this->data .= "<div id='notes'>";
	foreach ($this->notes as $n) {
		$this->data .= $n."<br>";
	}
	$this->data .= "</div>";
}
// CLOSE
$this->data .= "</div></body></html>";
?>