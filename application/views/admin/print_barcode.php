<?php

if( isset($data) )
{
	$items = count($data);
	$cpr 		= 5;
	$rows 	= ceil($items/$cpr);
	$ph		= 282; /// page height; 
	$rh		= 15; /// row height in mm;
	$pp		= floor($ph/$rh); /// rows per page
	$page 	= ceil($rows/$pp);  /// total_page
	$page_break = "page-break-after:always;";
	echo $this->printer->doc_header();
	$n		= 1;
	$i 		= 1;
	while($i<=$page)
	{
		$r = 1;
		if($i == $page){ $page_break = ""; }
		echo "<div style='width:".$this->printer->page_width."mm; line-height: 10mm; float:left; text-align:right;'><span style='position:relative; bottom: 0mm;'>หน้า ".$i."/".$page."</span></div>";
		echo "<div class='page_layout' style='width:".$this->printer->page_width."mm; padding-top:5mm; height:".$ph."mm; margin:auto; ".$page_break."'>"; //// page start
		echo "<table class='table' style='margin-bottom: 2px;'>";
		while($r<= $pp)
		{
			$c = 1;
			echo "<tr style='height:".$rh."mm;'>";
			while($c <= $cpr)
			{
				echo "<td>";
				if(isset($data[$n]['barcode']) ) :
					echo $this->printer->print_barcode($data[$n]['barcode'], "width:100px;");
				endif;
				echo "</td>";
				$c++;	
				$n++;
			}
			
			echo "</tr>";
			$r++;	
		}	
		echo "</table>";
		echo "</div><div class='hidden-print' style='height: 5mm; width:".$this->printer->page_width."'></div>";	// page end
		$i++;
	}
	echo $this->printer->doc_footer();
}

?>